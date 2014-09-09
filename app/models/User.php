<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * User
 */
class User extends Eloquent implements UserInterface, RemindableInterface
{

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'activationCode', 'remember_token'];

	protected $fillable = ['email', 'password'];

	protected $guarded = ['id', 'password'];

	/**
	 * Validation SignIn rules
	 *
	 * @var array
	 */
	public static $signInRules = [
		'email'    => 'required|email|min:5|max:30',
		'password' => 'required|min:3|max:20'
	];

	/**
	 * Validation SignUp rules
	 *
	 * @var array
	 */
	public static $signUpRules = [
		'email'    => 'required|email|unique:users|min:5|max:30',
		'password' => 'required|confirmed|min:3|max:20'
	];

	/**
	 * @return mixed|static
	 */
	public function register() {
		$this->password = Hash::make($this->password);
		$this->activationCode = $this->generateCode();
		$this->isActive = false;
		$this->save();

		Log::info("User [{$this->email}] registered. Activation code: {$this->activationCode}");

		$this->sendActivationMail();

		return $this->id;
	}

	public function sendActivationMail() {
		$activationUrl = action(
			'activate',
			[
				'userId'         => $this->id,
				'activationCode' => $this->activationCode,
			]
		);

		Mail::send(
			'emails/auth/activation',
			['activationUrl' => $activationUrl],
			function ($message) {
				$message->to($this->email)->subject('Спасибо за регистрацию');
			}
		);
	}

	public function activate($activationCode) {
		if ($this->isActive) {
			return false;
		}

		if ($activationCode != $this->activationCode) {
			return false;
		}

		$this->activationCode = '';
		$this->isActive = true;
		$this->save();

		Log::info("User [{$this->email}] successfully activated");

		return true;
	}

	/**
	 * @return mixed|static
	 */
	public function name() {
		return $this->nick_name ?: $this->email;
	}

	/**
	 * @return string
	 */
	public function fullName() {
		return $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * @return mixed
	 */
	public function getNicknameOrId() {
		return $this->nick_name ?: $this->id;
	}

	private function generateCode() {
		return Str::random();
	}
}