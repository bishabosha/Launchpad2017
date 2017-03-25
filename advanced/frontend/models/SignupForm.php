<?php
namespace frontend\models;

use function Sodium\compare;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;


    public $email;
    public $password;
    public $password2;
    public $bio;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'password', 'password2', 'bio'], 'required'],
            ['firstname', 'string'],
            ['firstname', 'match', 'pattern' => '/^[A-Z]\'?[-a-z]+$/'],


            ['lastname', 'string'],
            ['lastname', 'match', 'pattern' => '/^[A-Z]\'?[-a-z]+$/'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 8],

            ['password2', 'compare', 'compareAttribute' => 'password','message' => 'The passwords you entered do not match.'],
            ['password2', 'string', 'min' => 8],

            ['bio', 'string', 'max' => 140, 'message' => 'Please use no more than 140 characters'],
            ['bio', 'trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();

        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->bio = $this->bio;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function attributeLabels()
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'password2' => 'Repeat password',
        ];
    }
}
