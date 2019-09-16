<?php

namespace App\Units\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Domains\Users\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Domains\Companies\Models\Company;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Units\Auth\Notifications\LinkToVerifyEmail as LinkToVerifyEmailNotification;
use App\Units\Auth\Notifications\LinkToResetPassword as LinkToResetPasswordNotification;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'last_login_id',
        'is_enabled',
        'name',
        'email',
        'password',
        'api_token',
        'session_id',
        'email_verified_at',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'session_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_date',
        'last_login_at',
        'email_verified_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function logins()
    {
        return $this->hasMany(Login::class, 'user_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * Additional payload data.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        $payload = [
            // 'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];

        $this->loadMissing('company');

        if ($this->relationLoaded('company') && ! empty($this->getRelation('company'))) {
            $payload['company_key'] = $this->company->getKey();
        }

        return $payload;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new LinkToResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new LinkToVerifyEmailNotification());
    }

    private function getUserRole(): Role
    {
        static $result;

        if (! empty($result))
            return $result;

        return $result = $this->role()->getResults();
    }

    public function isCompany()
    {
        return $this->roleIs('Company');
    }

    public function roleIs(string $code): bool
    {
        return ($this->getUserRole())->code === Str::kebab($code);
    }

    /**
     * Verifies that the user has the necessary permissions (Roles) to access the resource in question.
     *
     * @param array $roles
     * @param bool $strict
     *
     * @return  boolean
     */
    public function hasRole(array $roles, bool $strict = false): bool
    {
        if (Arr::first($roles) === '_all') {
            return true;
        }

        $roleCurrentUser = $this->getUserRole();

        foreach ($roles as $role) {
            if ($this->checkIfUserHasRole(Str::kebab($role), $roleCurrentUser->code)) {
                return true;
            }
        }

        if ($strict) {
            return false;
        }

        return $this->userRoleLevelIsHigherThanRoles($roles, $roleCurrentUser->level);
    }

    private function userRoleLevelIsHigherThanRoles(array $roles, int $roleLevelCurrentUser): bool
    {
        return Role::query()
                    ->whereIn('code', $roles)
                    ->where('level', '<=', $roleLevelCurrentUser)
                    ->get()
                    ->isNotEmpty();
    }

    private function checkIfUserHasRole(string $roleCode, string $roleCodeCurrentUser)
    {
        return (strtolower($roleCode) === strtolower($roleCodeCurrentUser)) ? true : false;
    }
}
