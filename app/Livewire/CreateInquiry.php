<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InquiryOwnerEmail;
use App\Notifications\InquiryUserEmail;

class CreateInquiry extends Component
{
  #[Rule('required')]
  public $firstname;

  #[Rule('required')]
  public $name;

  #[Rule('required')]
  public $street;

  #[Rule('required')]
  public $location;

  #[Rule('required', 'email')]
  public $email;

  public $phone;

  public $message;

  #[Rule('required')]
  public $privacy;

  #[Rule('required|array')]
  public $interest = [];

  public function save()
  {
    $this->validate();
    
    $inquiry = Inquiry::create(
      $this->only([
        'name', 
        'firstname',
        'email', 
        'street',
        'location',
        'phone',
      ])
    );

    $interest_string = implode(', ', $this->interest);
    $inquiry->interest = $interest_string;
    $inquiry->save();
    
    if (in_array('Gewerbefläche', $this->interest))
    {
      Notification::route('mail', env('MAIL_TO'))->notify(new InquiryOwnerEmail($inquiry));
    }

    Notification::route('mail', $inquiry->email)->notify(new InquiryUserEmail($inquiry));
    session()->flash('status', 'Inquiry was submitted');
    $this->reset();
    $this->render();
  }

  public function render()
  {
    return view('livewire.create-inquiry');
  }
}
