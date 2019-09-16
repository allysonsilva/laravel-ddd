# Gerenciamento de Empresas com Fornecedores

- `php artisan migrate`
- `php artisan db:seed --domain=Users`
- `php artisan db:seed --domain=Companies`
- `php artisan db:seed --domain=Suppliers`

## Estrutura da Aplicação - `app`

```
app
├── Core
│   ├── Console
│   │   ├── Kernel.php
│   │   └── Traits
│   │       └── ExposeBehaviors.php
│   ├── Exceptions
│   │   └── Handler.php
│   ├── Http
│   │   ├── Kernel.php
│   │   └── Middleware
│   │       ├── Authenticate.php
│   │       ├── CheckForMaintenanceMode.php
│   │       ├── EncryptCookies.php
│   │       ├── RedirectIfAuthenticated.php
│   │       ├── TrimStrings.php
│   │       ├── TrustProxies.php
│   │       └── VerifyCsrfToken.php
│   └── Providers
│       ├── AppServiceProvider.php
│       └── RouteServiceProvider.php
├── Domains
│   ├── Companies
│   │   ├── Console
│   │   │   └── Closures
│   │   │       └── ClosureCommands.php
│   │   ├── Database
│   │   │   ├── Factories
│   │   │   │   └── CompanyFactory.php
│   │   │   ├── Migrations
│   │   │   │   └── 2019_07_01_203524_create_companies_table.php
│   │   │   └── Seeders
│   │   │       └── DatabaseSeeder.php
│   │   ├── Http
│   │   │   ├── Controllers
│   │   │   │   ├── Api
│   │   │   │   │   └── CompanyController.php
│   │   │   │   └── CompanyController.php
│   │   │   ├── Requests
│   │   │   │   └── CompanyFormRequest.php
│   │   │   ├── Resources
│   │   │   │   └── CompanyResource.php
│   │   │   └── Routes
│   │   │       ├── Api.php
│   │   │       └── Web.php
│   │   ├── Models
│   │   │   ├── Company.php
│   │   │   └── Traits
│   │   │       ├── CompanyBoot.php
│   │   │       └── CompanyRelationship.php
│   │   ├── Policies
│   │   │   └── CompanyPolicy.php
│   │   ├── Providers
│   │   │   ├── AuthServiceProvider.php
│   │   │   ├── CompanyServiceProvider.php
│   │   │   └── RouteServiceProvider.php
│   │   ├── Repositories
│   │   │   ├── CompanyRepository.php
│   │   │   ├── Criteria
│   │   │   │   └── JoinUserCriteria.php
│   │   │   └── Filterable
│   │   │       └── CompanyBuilderFilter.php
│   │   ├── Resources
│   │   │   └── Views
│   │   │       ├── _filter.blade.php
│   │   │       ├── _form.blade.php
│   │   │       ├── _header.blade.php
│   │   │       ├── create.blade.php
│   │   │       ├── edit.blade.php
│   │   │       └── index.blade.php
│   │   └── Services
│   │       └── CompanyService.php
│   ├── DomainServiceProvider.php
│   ├── Suppliers
│   │   ├── Console
│   │   │   └── Closures
│   │   │       └── ClosureCommands.php
│   │   ├── Database
│   │   │   ├── Factories
│   │   │   │   └── SupplierFactory.php
│   │   │   ├── Migrations
│   │   │   │   └── 2019_07_01_240880_create_suppliers_table.php
│   │   │   └── Seeders
│   │   │       ├── DatabaseSeeder.php
│   │   │       └── SuppliersTableSeeder.php
│   │   ├── Http
│   │   │   ├── Controllers
│   │   │   │   ├── Api
│   │   │   │   │   └── SupplierController.php
│   │   │   │   ├── SupplierController.php
│   │   │   │   └── SupplierGuestController.php
│   │   │   ├── Requests
│   │   │   │   └── SupplierFormRequest.php
│   │   │   ├── Resources
│   │   │   │   └── SupplierResource.php
│   │   │   └── Routes
│   │   │       ├── Api.php
│   │   │       ├── Web.php
│   │   │       └── WebGuest.php
│   │   ├── Models
│   │   │   ├── Supplier.php
│   │   │   └── Traits
│   │   │       ├── Boots
│   │   │       │   └── QueryFilterSuppliersByUsers.php
│   │   │       ├── Scopes
│   │   │       │   └── SuppliersOnlyCompanyScope.php
│   │   │       ├── SupplierFunction.php
│   │   │       └── SupplierRelationship.php
│   │   ├── Notifications
│   │   │   └── LinkToSupplierActivation.php
│   │   ├── Pipelines
│   │   │   └── SanitizeMonthlyPayment.php
│   │   ├── Policies
│   │   │   └── SupplierPolicy.php
│   │   ├── Providers
│   │   │   ├── AuthServiceProvider.php
│   │   │   ├── RouteServiceProvider.php
│   │   │   └── SupplierServiceProvider.php
│   │   ├── Repositories
│   │   │   ├── Filterable
│   │   │   │   └── SupplierBuilderFilter.php
│   │   │   └── SupplierRepository.php
│   │   ├── Resources
│   │   │   └── Views
│   │   │       ├── _filter.blade.php
│   │   │       ├── _form.blade.php
│   │   │       ├── _header.blade.php
│   │   │       ├── create.blade.php
│   │   │       ├── edit.blade.php
│   │   │       └── index.blade.php
│   │   └── Services
│   │       └── SupplierService.php
│   └── Users
│       ├── Console
│       │   ├── Closures
│       │   │   └── ClosureCommands.php
│       │   └── Commands
│       │       └── UserCommand.php
│       ├── Database
│       │   ├── Factories
│       │   │   ├── UserAdminRoleFactory.php
│       │   │   ├── UserCompanyRoleFactory.php
│       │   │   ├── UserFactory.php
│       │   │   └── UserSuperAdminRoleFactory.php
│       │   ├── Migrations
│       │   │   ├── 2019_07_01_049635_create_roles_table.php
│       │   │   ├── 2019_07_01_113233_create_logins_table.php
│       │   │   ├── 2019_07_01_117085_create_users_table.php
│       │   │   └── 2019_08_23_101100_add_session_id_to_users_table.php
│       │   └── Seeders
│       │       ├── AdminsUsersTableSeeder.php
│       │       ├── CompaniesUsersTableSeeder.php
│       │       ├── DatabaseSeeder.php
│       │       ├── RolesTableSeeder.php
│       │       ├── SQL
│       │       │   └── roles.sql
│       │       └── SuperAdminsUsersTableSeeder.php
│       ├── Http
│       │   ├── Controllers
│       │   │   ├── Api
│       │   │   │   └── UserController.php
│       │   │   └── UserController.php
│       │   ├── Requests
│       │   │   └── UserFormRequest.php
│       │   └── Routes
│       │       ├── Api.php
│       │       └── Web.php
│       ├── Models
│       │   ├── Admin.php
│       │   ├── Company.php
│       │   ├── Role.php
│       │   ├── SuperAdmin.php
│       │   ├── Traits
│       │   │   ├── RoleRelationship.php
│       │   │   ├── UserAccessor.php
│       │   │   ├── UserBoot.php
│       │   │   ├── UserFunction.php
│       │   │   ├── UserRelationship.php
│       │   │   └── UserScope.php
│       │   └── User.php
│       ├── Observers
│       │   └── UserObserver.php
│       ├── Policies
│       │   └── UserPolicy.php
│       ├── Providers
│       │   ├── AuthServiceProvider.php
│       │   ├── BindServiceProvider.php
│       │   ├── EventServiceProvider.php
│       │   ├── RouteServiceProvider.php
│       │   └── UserServiceProvider.php
│       ├── Repositories
│       │   ├── Criteria
│       │   │   ├── JoinRoleCriteria.php
│       │   │   └── UserPermissionCriteria.php
│       │   ├── Filterable
│       │   │   └── UserBuilderFilter.php
│       │   ├── Filters
│       │   │   └── NameOrEmail.php
│       │   ├── RoleRepository.php
│       │   └── UserRepository.php
│       ├── Resources
│       │   ├── Lang
│       │   │   ├── en
│       │   │   │   └── messages.php
│       │   │   └── pt_BR
│       │   │       └── messages.php
│       │   └── Views
│       │       ├── _filter.blade.php
│       │       ├── _form.blade.php
│       │       ├── _header.blade.php
│       │       ├── create.blade.php
│       │       ├── edit.blade.php
│       │       └── index.blade.php
│       └── Services
│           └── UserService.php
├── Support
│   ├── Console
│   │   └── Routing
│   │       └── RouteFile.php
│   ├── Database
│   │   ├── Console
│   │   │   ├── ArtisanServiceProvider.php
│   │   │   ├── Factories
│   │   │   │   ├── FactoryMakeCommand.php
│   │   │   │   └── stubs
│   │   │   │       └── factory.stub
│   │   │   ├── Migrations
│   │   │   │   ├── Contracts
│   │   │   │   │   └── MigrationConstants.php
│   │   │   │   ├── MigrateCommand.php
│   │   │   │   ├── MigrateMakeCommand.php
│   │   │   │   ├── ResetCommand.php
│   │   │   │   ├── RollbackCommand.php
│   │   │   │   ├── StatusCommand.php
│   │   │   │   └── Traits
│   │   │   │       └── MigrationPathsTrait.php
│   │   │   ├── Seeds
│   │   │   │   ├── SeedCommand.php
│   │   │   │   ├── SeederMakeCommand.php
│   │   │   │   └── stubs
│   │   │   │       └── seeder.stub
│   │   │   └── Traits
│   │   │       ├── DefaultToGeneratorCommand.php
│   │   │       ├── DomainArgument.php
│   │   │       └── DomainComponentNamespace.php
│   │   ├── ConsoleSupportServiceProvider.php
│   │   └── Eloquent
│   │       └── ModelFactory.php
│   ├── Domain
│   │   └── ServiceProvider.php
│   ├── Exceptions
│   │   ├── BaseException.php
│   │   └── HttpException
│   │       ├── BadRequestException.php
│   │       ├── ConflictException.php
│   │       ├── ForbiddenException.php
│   │       ├── InternalServerErrorException.php
│   │       ├── NotFoundException.php
│   │       ├── RequestTimeoutException.php
│   │       ├── RequestUriTooLongException.php
│   │       ├── UnauthorizedException.php
│   │       └── UnprocessableEntityException.php
│   ├── Helpers
│   │   └── ApplicationHelper.php
│   ├── Http
│   │   └── Controller.php
│   ├── Localization
│   │   └── LocalizationServiceProvider.php
│   ├── Models
│   │   ├── BaseCollection.php
│   │   ├── BaseEloquentBuilder.php
│   │   └── BaseModel.php
│   ├── Queue
│   │   ├── HorizonApplicationServiceProvider.php
│   │   └── HorizonServiceProvider.php
│   ├── Repository
│   │   ├── Eloquent
│   │   │   ├── BaseRepository.php
│   │   │   ├── Contracts
│   │   │   │   ├── CriterionInterface.php
│   │   │   │   └── RepositoryInterface.php
│   │   │   ├── Criteria
│   │   │   │   └── FindWhere.php
│   │   │   ├── Filterable
│   │   │   │   ├── Clauses
│   │   │   │   │   ├── OrWhereClause.php
│   │   │   │   │   ├── OrWhereLikeClause.php
│   │   │   │   │   ├── WhereClause.php
│   │   │   │   │   └── WhereLikeClause.php
│   │   │   │   ├── Constants
│   │   │   │   │   ├── GroupBy.php
│   │   │   │   │   ├── Limit.php
│   │   │   │   │   ├── OrderBy.php
│   │   │   │   │   ├── Page.php
│   │   │   │   │   └── SortBy.php
│   │   │   │   ├── Contracts
│   │   │   │   │   ├── ClausesInterface.php
│   │   │   │   │   └── FiltersInterface.php
│   │   │   │   └── QueryBuilderFilter.php
│   │   │   ├── Operations
│   │   │   │   ├── RepositoryCreate.php
│   │   │   │   ├── RepositoryDelete.php
│   │   │   │   ├── RepositoryRead.php
│   │   │   │   └── RepositoryUpdate.php
│   │   │   └── Traits
│   │   │       ├── CacheableRepository.php
│   │   │       └── HandleCriteria.php
│   │   └── Exceptions
│   │       └── RepositoryException.php
│   ├── Service
│   │   ├── BaseService.php
│   │   └── Operations
│   │       ├── ServiceCreate.php
│   │       ├── ServiceDelete.php
│   │       ├── ServiceRead.php
│   │       └── ServiceUpdate.php
│   ├── Specifications
│   │   ├── AbstractPermissionSpecification.php
│   │   ├── AbstractRoleSpecification.php
│   │   ├── AndSpecification.php
│   │   ├── Contracts
│   │   │   └── Specification.php
│   │   ├── NotSpecification.php
│   │   └── OrSpecification.php
│   ├── SupportServiceProvider.php
│   ├── Validator
│   │   └── FormRequestValidator.php
│   └── View
│       ├── Building
│       │   ├── BladeExtensionsServiceProvider.php
│       │   ├── FormServiceProvider.php
│       │   └── LayoutServiceProvider.php
│       ├── Composers
│       │   └── FormValidationClassComposer.php
│       └── ViewServiceProvider.php
└── Units
    ├── Auth
    │   ├── Http
    │   │   ├── Controllers
    │   │   │   ├── Api
    │   │   │   │   ├── AuthController.php
    │   │   │   │   ├── Controller.php
    │   │   │   │   ├── ForgotPasswordController.php
    │   │   │   │   ├── MeController.php
    │   │   │   │   ├── RegisterController.php
    │   │   │   │   ├── ResetPasswordController.php
    │   │   │   │   └── Traits
    │   │   │   │       ├── Respond.php
    │   │   │   │       └── Token.php
    │   │   │   └── Web
    │   │   │       ├── Controller.php
    │   │   │       ├── ForgotPasswordController.php
    │   │   │       ├── LoginController.php
    │   │   │       ├── RegisterController.php
    │   │   │       ├── ResetPasswordController.php
    │   │   │       └── VerificationController.php
    │   │   ├── Middleware
    │   │   │   ├── ApiAuthenticate.php
    │   │   │   └── CheckRole.php
    │   │   ├── Resources
    │   │   │   └── UserResource.php
    │   │   └── Routes
    │   │       ├── Api.php
    │   │       └── Web.php
    │   ├── Listeners
    │   │   ├── SendEmailSuccessfullyVerifiedNotification.php
    │   │   ├── SendPasswordSuccessfullyResetNotification.php
    │   │   └── SendVerifyEmailNotification.php
    │   ├── Login.php
    │   ├── Notifications
    │   │   ├── EmailSuccessfullyVerified.php
    │   │   ├── LinkToResetPassword.php
    │   │   ├── LinkToVerifyEmail.php
    │   │   ├── PasswordSuccessfullyReset.php
    │   │   ├── ResetPasswordNotificationToMail.php
    │   │   └── VerifyEmailNotificationToMail.php
    │   ├── Providers
    │   │   ├── AuthServiceProvider.php
    │   │   ├── EventServiceProvider.php
    │   │   ├── RouteServiceProvider.php
    │   │   └── UnitServiceProvider.php
    │   ├── Resources
    │   │   └── Views
    │   │       ├── login.blade.php
    │   │       ├── passwords
    │   │       │   ├── email.blade.php
    │   │       │   └── reset.blade.php
    │   │       ├── register.blade.php
    │   │       └── verify.blade.php
    │   ├── Services
    │   │   ├── OneSessionPerUser.php
    │   │   ├── StoreUserAndCompany.php
    │   │   └── UpdateUserLastLogin.php
    │   └── User.php
    └── Dashboard
        ├── Http
        │   ├── Controllers
        │   │   └── Web
        │   │       └── DashboardController.php
        │   └── Routes
        │       └── Web.php
        ├── Providers
        │   ├── RouteServiceProvider.php
        │   └── UnitServiceProvider.php
        └── Resources
            └── Views
                └── index.blade.php
```
