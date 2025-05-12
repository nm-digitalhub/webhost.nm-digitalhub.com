# Project Structure Documentation

📁 Scanned directory: `.`

## Directory Tree

```
.
├── .claude
│   └── settings.local.json
├── .editorconfig
├── .env
├── .env.example
├── .env.oauth.example
├── .gitattributes
├── .gitignore
├── .idea
│   ├── .gitignore
│   ├── commandlinetools
│   │   ├── Laravel_4_5_2025__17_26.xml
│   │   └── schemas
│   │       └── frameworkDescriptionVersion1.1.4.xsd
│   ├── dataSources
│   │   ├── 69182024-69e4-4220-8ea0-9798fca6889d
│   │   │   └── storage_v2
│   │   │       └── _src_
│   │   │           └── schema
│   │   │               └── information_schema.FNRwLQ.meta
│   │   ├── 69182024-69e4-4220-8ea0-9798fca6889d.corrupted.20250512-125115.reason.txt
│   │   └── 69182024-69e4-4220-8ea0-9798fca6889d.corrupted.20250512-125115.xml
│   ├── dataSources.local.xml
│   ├── dataSources.xml
│   ├── forwardedPorts.xml
│   ├── laravel-idea.xml
│   ├── modules.xml
│   ├── php-test-framework.xml
│   ├── php.xml
│   ├── phpunit.xml
│   ├── sqldialects.xml
│   ├── watcherTasks.xml
│   ├── webhost.nm-digitalhub.com.iml
│   └── workspace.xml
├── .phpunit.result.cache
├── AuthRoutes.php
├── CLAUDE.md
├── CLIENT_PANEL_MODULES.md
├── Clear.log
├── CodeQualityImprovementGuide.md
├── CodeQualityRecommendations.md
├── ComponentOptimizationRecommendations.md
├── CreateAdminUserCommand.php
├── FILAMENT_PHPDOC_TEMPLATES.md
├── MODULE_IMPLEMENTATION_SUMMARY.md
├── NM-DigitalHUB_Structure.md
├── NM_DigitalHUB_Project_Structure.md
├── NM_DigitalHUB_Structure.md
├── ProjectAnalysisReport.md
├── ProjectAnalysisReport2.md
├── README.md
├── ROLES_SETUP_INSTRUCTIONS.md
├── RoleUserMigration.php
├── RoleUserMigration2.php
├── RoleValidationRule.php
├── SETUP.md
├── WebRoutes.php
├── WebRoutes2.php
├── admin-dashboard.zip
├── admin-panel-changes-log.md
├── admin-panel-code.zip
├── admin_structure.zip
├── admin_web_bundle.zip
├── all_code_dump.txt
├── analyse-project.sh
├── app
│   ├── Actions
│   │   ├── Fortify
│   │   │   ├── ConfirmPassword.php
│   │   │   ├── CreateNewUser.php
│   │   │   ├── PasswordValidationRules.php
│   │   │   ├── ResetUserPassword.php
│   │   │   ├── UpdateUserPassword.php
│   │   │   └── UpdateUserProfileInformation.php
│   │   └── Jetstream
│   │       └── DeleteUser.php
│   ├── Console
│   │   ├── Commands
│   │   │   ├── CreateAdminUser.php
│   │   │   ├── CreateAdminUserCommand.php
│   │   │   ├── FixLivewireNamespaces.php
│   │   │   ├── GenerateUiMapCommand.php
│   │   │   ├── MakeViewCommand.php
│   │   │   ├── SetupAdminRole.php
│   │   │   └── SetupRolesAndAdmin.php
│   │   └── Kernel.php
│   ├── Contracts
│   │   └── PaymentGateway.php
│   ├── Filament
│   │   ├── Admin
│   │   │   └── Resources
│   │   │       ├── RoleResource
│   │   │       │   └── Pages
│   │   │       │       ├── CreateRole.php
│   │   │       │       ├── EditRole.php
│   │   │       │       └── ListRoles.php
│   │   │       ├── RoleResource.php
│   │   │       ├── Spatie
│   │   │       │   └── Permission
│   │   │       │       └── Models
│   │   │       │           ├── PermissionResource
│   │   │       │           │   └── Pages
│   │   │       │           │       ├── CreatePermission.php
│   │   │       │           │       ├── EditPermission.php
│   │   │       │           │       └── ListPermissions.php
│   │   │       │           └── PermissionResource.php
│   │   │       ├── UserResource
│   │   │       │   └── Pages
│   │   │       │       ├── CreateUser.php
│   │   │       │       ├── EditUser.php
│   │   │       │       └── ListUsers.php
│   │   │       └── UserResource.php
│   │   ├── Pages
│   │   │   └── Dashboard.php
│   │   ├── Resources
│   │   │   ├── ClientModuleResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateClientModule.php
│   │   │   │       ├── EditClientModule.php
│   │   │   │       └── ListClientModules.php
│   │   │   ├── ClientModuleResource.php
│   │   │   ├── ClientPageResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateClientPage.php
│   │   │   │       ├── EditClientPage.php
│   │   │   │       └── ListClientPages.php
│   │   │   ├── ClientPageResource.php
│   │   │   ├── GenerationLogResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateGenerationLog.php
│   │   │   │       ├── EditGenerationLog.php
│   │   │   │       └── ListGenerationLogs.php
│   │   │   ├── GenerationLogResource.php
│   │   │   ├── GeneratorResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateGenerator.php
│   │   │   │       ├── EditGenerator.php
│   │   │   │       ├── GenerateCode.php
│   │   │   │       └── ListGenerators.php
│   │   │   ├── GeneratorResource.php
│   │   │   ├── MailSettingResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateMailSetting.php
│   │   │   │       ├── EditMailSetting.php
│   │   │   │       └── ListMailSettings.php
│   │   │   ├── MailSettingResource.php
│   │   │   ├── MailTemplateResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateMailTemplate.php
│   │   │   │       ├── EditMailTemplate.php
│   │   │   │       └── ListMailTemplates.php
│   │   │   ├── MailTemplateResource.php
│   │   │   ├── ModuleManagerResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateModule.php
│   │   │   │       ├── CreateModuleManager.php
│   │   │   │       ├── EditModule.php
│   │   │   │       ├── EditModuleManager.php
│   │   │   │       ├── ListModuleManagers.php
│   │   │   │       ├── ListModules.php
│   │   │   │       ├── ViewComponentCode.php
│   │   │   │       └── list-module-managers.blade.php
│   │   │   ├── ModuleManagerResource.php
│   │   │   ├── PageResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreatePage.php
│   │   │   │       ├── EditPage.php
│   │   │   │       └── ListPages.php
│   │   │   ├── PageResource.php
│   │   │   ├── ProductResource
│   │   │   │   └── Pages
│   │   │   │       ├── CreateProduct.php
│   │   │   │       ├── EditProduct.php
│   │   │   │       └── ListProducts.php
│   │   │   ├── ProductResource.php
│   │   │   ├── UserResource
│   │   │   │   └── Pages
│   │   │   │       └── ListUsers.php
│   │   │   └── UserResource.php
│   │   └── Widgets
│   │       ├── LatestActivityWidget.php
│   │       ├── ModulesStatsWidget.php
│   │       ├── SystemHealthWidget.php
│   │       ├── SystemResourcesWidget.php
│   │       └── UsersStatsWidget.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── AdminController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── UserController.php
│   │   │   ├── AdminController.php
│   │   │   ├── Api
│   │   │   │   └── DomainController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Client
│   │   │   │   ├── BillingController.php
│   │   │   │   ├── ClientController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── DomainController.php
│   │   │   │   ├── PageController.php
│   │   │   │   ├── ServiceController.php
│   │   │   │   └── SupportController.php
│   │   │   ├── ClientController.php
│   │   │   ├── CodeScanController.php
│   │   │   ├── Controller.php
│   │   │   ├── FileScanController.php
│   │   │   ├── GoogleOAuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ImpersonationController.php
│   │   │   ├── LanguageController.php
│   │   │   ├── PageController.php
│   │   │   └── ProfileController.php
│   │   ├── Kernel.php
│   │   ├── Livewire
│   │   │   └── Admin
│   │   │       └── Settings.php
│   │   ├── Middleware
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── CheckRole.php
│   │   │   ├── EnsurePasswordIsConfirmed.php
│   │   │   ├── IsAdmin.php
│   │   │   ├── IsClient.php
│   │   │   ├── RoleMiddleware.php
│   │   │   ├── SetLocale.php
│   │   │   └── VerifyScanApiKey.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Livewire
│   │   ├── Admin
│   │   │   ├── AdminLayout.php
│   │   │   ├── Dashboard.php
│   │   │   ├── DomainCard.php
│   │   │   ├── Domains.php
│   │   │   ├── DomainsNew.php
│   │   │   ├── Hosting.php
│   │   │   ├── Invoices.php
│   │   │   ├── Orders.php
│   │   │   ├── Plans.php
│   │   │   ├── Settings.php
│   │   │   ├── Tickets.php
│   │   │   ├── Users.php
│   │   │   └── Vps.php
│   │   ├── Auth
│   │   │   ├── ConfirmPassword.php
│   │   │   ├── ForgotPassword.php
│   │   │   ├── Login.php
│   │   │   ├── Register.php
│   │   │   ├── ResetPassword.php
│   │   │   └── VerifyEmail.php
│   │   └── Client
│   │       ├── Dashboard.php
│   │       ├── DomainCheck.php
│   │       ├── Domains.php
│   │       ├── Hosting.php
│   │       ├── HostingNew.php
│   │       ├── Invoices.php
│   │       ├── Settings.php
│   │       ├── Support.php
│   │       ├── SupportNew.php
│   │       └── Vps.php
│   ├── Models
│   │   ├── Cart.php
│   │   ├── CartItem.php
│   │   ├── ClientModule.php
│   │   ├── ClientPage.php
│   │   ├── ComponentMetadata.php
│   │   ├── Coupon.php
│   │   ├── GenerationLog.php
│   │   ├── Generator.php
│   │   ├── ImpersonationLog.php
│   │   ├── MailSetting.php
│   │   ├── MailTemplate.php
│   │   ├── Module.php
│   │   ├── ModuleManager.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Page.php
│   │   ├── Plan.php
│   │   ├── PlanFeature.php
│   │   ├── Product.php
│   │   ├── Transaction.php
│   │   └── User.php
│   ├── Notifications
│   │   ├── NewUserWelcomeNotification.php
│   │   └── TestSmtpNotification.php
│   ├── Policies
│   │   ├── MailSettingPolicy.php
│   │   └── MailTemplatePolicy.php
│   ├── Providers
│   │   ├── AppServiceProvider.php
│   │   ├── ClientPanelProvider.php
│   │   ├── Filament
│   │   │   ├── AdminPanelProvider.php
│   │   │   └── ThemeServiceProvider.php
│   │   ├── FilamentServiceProvider.php
│   │   ├── FortifyServiceProvider.php
│   │   ├── JetstreamServiceProvider.php
│   │   ├── MiddlewareServiceProvider.php
│   │   └── RouteServiceProvider.php
│   ├── Services
│   │   ├── GeneratorService.php
│   │   ├── ImpersonationService.php
│   │   ├── Mail
│   │   │   ├── GoogleMailTransport.php
│   │   │   ├── GoogleOAuthService.php
│   │   │   └── MailTemplateManager.php
│   │   ├── ModuleInstaller.php
│   │   ├── ModuleScanner.php
│   │   └── Payment
│   │       ├── AbstractPaymentGateway.php
│   │       ├── CardcomGateway.php
│   │       ├── PaymentGatewayFactory.php
│   │       └── TranzilaGateway.php
│   └── View
│       └── Components
│           ├── AppLayout.php
│           ├── GuestLayout.php
│           ├── KpiSummaryBar.php
│           └── PrimaryButton.php
├── artisan
├── bash
├── bootstrap
│   ├── app.php
│   ├── app.php.bak
│   ├── cache
│   │   ├── .gitignore
│   │   ├── filament
│   │   │   └── panels
│   │   ├── packages.php
│   │   └── services.php
│   └── providers.php
├── build
├── builder_resources.zip
├── builder_resources_for_editing.zip
├── builder_resources_with_readme.zip
├── check_and_fix_sanctum.sh
├── check_modules.php
├── check_sanctum_token.sh
├── code_quality_audit.md
├── collect-project-files.sh
├── composer-packages.txt
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filament.php
│   ├── filament_custom.php
│   ├── filesystems.php
│   ├── fortify.php
│   ├── jetstream.php
│   ├── livewire.php
│   ├── logging.php
│   ├── mail.php
│   ├── permission.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   └── session.php
├── cookies.txt
├── create_cache_tables.sql
├── dashboard_review.zip
├── database
│   ├── .gitignore
│   ├── database.sqlite
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 2024_01_01_000001_create_client_modules_table.php
│   │   ├── 2025_05_05_042346_create_permission_tables.php
│   │   ├── 2025_05_05_042501_create_roles_table.php
│   │   ├── 2025_05_05_042501_create_users_table.php
│   │   ├── 2025_05_05_042503_create_role_user_table.php
│   │   ├── 2025_05_05_044303_create_admin_user.php
│   │   ├── 2025_05_05_044808_create_cache_table.php
│   │   ├── 2025_05_05_045429_create_sessions_table.php
│   │   ├── 2025_05_06_024421_add_is_admin_to_users_table.php
│   │   ├── 2025_05_06_065448_create_generators_table.php
│   │   ├── 2025_05_06_091348_create_generation_logs_table.php
│   │   ├── 2025_05_06_091429_add_generation_fields_to_generators_table.php
│   │   ├── 2025_05_06_093159_create_products_table.php
│   │   ├── 2025_05_06_181117_create_password_reset_tokens_table.php
│   │   ├── 2025_05_06_200000_upgrade_existing_schema.php
│   │   ├── 2025_05_06_231036_add_module_id_to_client_pages_table.php
│   │   ├── 2025_05_06_235309_create_mail_templates_table.php
│   │   ├── 2025_05_06_235312_create_mail_settings_table.php
│   │   ├── 2025_05_06_300000_create_client_modules_table.php
│   │   ├── 2025_05_06_300001_create_client_pages_table.php
│   │   ├── 2025_05_06_300002_create_impersonation_logs_table.php
│   │   ├── 2025_05_07_000001_update_products_table.php
│   │   ├── 2025_05_07_000002_create_plans_table.php
│   │   ├── 2025_05_07_000003_create_plan_features_table.php
│   │   ├── 2025_05_07_000004_create_orders_table.php
│   │   ├── 2025_05_07_000005_create_order_items_table.php
│   │   ├── 2025_05_07_000006_create_transactions_table.php
│   │   ├── 2025_05_07_001326_add_reply_to_to_mail_settings_table.php
│   │   ├── 2025_05_07_001327_add_google_oauth_to_mail_settings_table.php
│   │   ├── 2025_05_07_141557_create_notifications_table.php
│   │   ├── 2025_05_08_000001_create_modules_table.php
│   │   ├── 2025_05_08_000002_create_carts_table.php
│   │   ├── 2025_05_08_000003_create_cart_items_table.php
│   │   ├── 2025_05_08_000004_create_coupons_table.php
│   │   ├── 2025_05_08_000005_create_pages_table.php
│   │   ├── 2025_05_08_000006_add_language_and_type_to_pages_table.php
│   │   ├── 2025_05_08_061159_increase_google_client_secret_length_in_mail_settings_table.php
│   │   ├── 2025_05_08_100000_add_foreign_keys.php
│   │   └── 2025_05_09_142533_create_module_managers_table.php
│   ├── migrations_backup
│   │   └── _backup_2025_05_05_024040_create_role_user_table.php
│   ├── migrations_backup_20250504075753
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000000_create_users_table.php.bak
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php.bak
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php.bak
│   │   ├── 2025_05_01_195229_add_two_factor_columns_to_users_table.php
│   │   ├── 2025_05_01_195238_create_personal_access_tokens_table.php
│   │   ├── 2025_05_01_195238_create_personal_access_tokens_table.php.bak
│   │   ├── 2025_05_01_195534_create_roles_table.php
│   │   ├── 2025_05_01_195534_create_roles_table.php.bak
│   │   ├── 2025_05_01_195611_create_role_user_table.php
│   │   ├── 2025_05_01_195611_create_role_user_table.php.bak
│   │   ├── 2025_05_04_070319_create_personal_access_tokens_table.php
│   │   ├── 2025_05_04_070319_create_personal_access_tokens_table.php.bak
│   │   └── corrected_migrations.zip
│   ├── migrations_backup_20250504_080051
│   ├── migrations_updated
│   │   ├── 2025_05_05_042346_create_permission_tables_optimized.php
│   │   ├── 2025_05_05_042501_create_users_table_optimized.php
│   │   ├── 2025_05_06_093159_create_products_table_optimized.php
│   │   ├── 2025_05_07_000002_create_plans_table_optimized.php
│   │   ├── 2025_05_07_000003_create_plan_features_table_optimized.php
│   │   ├── 2025_05_07_000004_create_orders_table_optimized.php
│   │   ├── 2025_05_07_000005_create_order_items_table_optimized.php
│   │   ├── 2025_05_07_000006_create_transactions_table_optimized.php
│   │   ├── 2025_05_08_000002_create_carts_table_optimized.php
│   │   ├── 2025_05_08_000003_create_cart_items_table_optimized.php
│   │   ├── 2025_05_08_000004_create_coupons_table_optimized.php
│   │   ├── 2025_05_08_000005_create_pages_table_optimized.php
│   │   └── IMPROVEMENTS_SUMMARY.md
│   ├── schema
│   │   └── mysql-schema.sql
│   └── seeders
│       ├── ClientModulesSeeder.php
│       ├── CreateRolesAndSetAdminSeeder.php
│       ├── DatabaseSeeder.php
│       ├── GeneratorsSeeder.php
│       ├── ModulesSeeder.php
│       ├── PageSeeder.php
│       ├── RoleSeeder.php
│       ├── RolesAndAdminSeeder.php
│       └── permissionsSeeder.php
├── diagnose-and-fix.sh
├── diagnostic.log
├── filament_fix_report.md
├── filament_fixes_summary.md
├── filament_review.zip
├── filament_routes_report.txt
├── filament_structure.txt
├── files_for_review_2025-05-12.zip
├── files_for_review_2025-05-12_02-05.zip
├── fix.txt
├── fix_sanctum_middleware.sh
├── gpt.log
├── invalid-methods.log
├── list.txt
├── livewire_component_mapping.md
├── livewire_component_mapping2.md
├── livewire_component_mappings.md
├── livewire_component_mappings2.md
├── log.txt
├── logApi.txt
├── loglevelmax.txt
├── lognew1.txt
├── logtest.txt
├── menu_items_detailed.txt
├── menu_items_paths.txt
├── menu_navigation_status.txt
├── models.txt
├── newlog.txt
├── nm-digitalhub-backend
│   ├── .editorconfig
│   ├── .env
│   ├── .env.example
│   ├── .gitattributes
│   ├── .gitignore
│   ├── README.md
│   ├── app
│   │   ├── Http
│   │   │   └── Controllers
│   │   │       └── Controller.php
│   │   ├── Models
│   │   │   └── User.php
│   │   └── Providers
│   │       └── AppServiceProvider.php
│   ├── artisan
│   ├── bootstrap
│   │   ├── app.php
│   │   ├── cache
│   │   │   ├── .gitignore
│   │   │   ├── packages.php
│   │   │   └── services.php
│   │   └── providers.php
│   ├── composer.json
│   ├── composer.lock
│   ├── config
│   │   ├── app.php
│   │   ├── auth.php
│   │   ├── cache.php
│   │   ├── database.php
│   │   ├── filesystems.php
│   │   ├── logging.php
│   │   ├── mail.php
│   │   ├── queue.php
│   │   ├── services.php
│   │   └── session.php
│   ├── database
│   │   ├── .gitignore
│   │   ├── database.sqlite
│   │   ├── factories
│   │   │   └── UserFactory.php
│   │   ├── migrations
│   │   │   ├── 0001_01_01_000000_create_users_table.php
│   │   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   │   └── 0001_01_01_000002_create_jobs_table.php
│   │   └── seeders
│   │       └── DatabaseSeeder.php
│   ├── package.json
│   ├── phpunit.xml
│   ├── public
│   │   ├── .htaccess
│   │   ├── favicon.ico
│   │   ├── index.php
│   │   └── robots.txt
│   ├── resources
│   │   ├── css
│   │   │   └── app.css
│   │   ├── js
│   │   │   ├── app.js
│   │   │   └── bootstrap.js
│   │   └── views
│   │       └── welcome.blade.php
│   ├── routes
│   │   ├── console.php
│   │   └── web.php
│   ├── tests
│   │   ├── Feature
│   │   │   └── ExampleTest.php
│   │   ├── TestCase.php
│   │   └── Unit
│   │       └── ExampleTest.php
│   └── vite.config.js
├── package-lock.json
├── package.json
├── php-files-list.txt
├── phpstan.neon
├── phpunit.xml
├── postcss.config.js
├── project_clean_2025-05-12_02-33.zip
├── project_directory_structure.md
├── project_directory_structure2.md
├── project_structure.md
├── project_structure_documentation.md
├── public
│   ├── .htaccess
│   ├── .php-ini
│   ├── .php-version
│   ├── app
│   │   └── Filament
│   │       └── Resources
│   ├── assets
│   │   ├── filament
│   │   │   ├── css
│   │   │   │   ├── app
│   │   │   │   │   ├── custom-fonts.css
│   │   │   │   │   └── nm-digitalhub-theme.css
│   │   │   │   └── filament
│   │   │   │       ├── filament
│   │   │   │       │   └── app.css
│   │   │   │       ├── forms
│   │   │   │       │   └── forms.css
│   │   │   │       └── support
│   │   │   │           └── support.css
│   │   │   └── js
│   │   │       └── filament
│   │   │           ├── filament
│   │   │           │   ├── app.js
│   │   │           │   └── echo.js
│   │   │           ├── forms
│   │   │           │   └── components
│   │   │           │       ├── color-picker.js
│   │   │           │       ├── date-time-picker.js
│   │   │           │       ├── file-upload.js
│   │   │           │       ├── key-value.js
│   │   │           │       ├── markdown-editor.js
│   │   │           │       ├── rich-editor.js
│   │   │           │       ├── select.js
│   │   │           │       ├── tags-input.js
│   │   │           │       └── textarea.js
│   │   │           ├── notifications
│   │   │           │   └── notifications.js
│   │   │           ├── support
│   │   │           │   └── support.js
│   │   │           ├── tables
│   │   │           │   └── components
│   │   │           │       └── table.js
│   │   │           └── widgets
│   │   │               └── components
│   │   │                   ├── chart.js
│   │   │                   └── stats-overview
│   │   │                       └── stat
│   │   │                           └── chart.js
│   │   ├── icons
│   │   │   ├── public
│   │   │   │   ├── assets
│   │   │   │   │   └── icons
│   │   │   │   │       ├── chart-line.svg
│   │   │   │   │       ├── cogs.svg
│   │   │   │   │       ├── database.svg
│   │   │   │   │       ├── envelope.svg
│   │   │   │   │       ├── globe.svg
│   │   │   │   │       ├── headset.svg
│   │   │   │   │       ├── home.svg
│   │   │   │   │       ├── key.svg
│   │   │   │   │       ├── lock.svg
│   │   │   │   │       ├── server.svg
│   │   │   │   │       ├── sign-in-alt.svg
│   │   │   │   │       ├── upload.svg
│   │   │   │   │       └── user-cog.svg
│   │   │   │   ├── icons
│   │   │   │   │   ├── chart-line.svg
│   │   │   │   │   ├── cogs.svg
│   │   │   │   │   ├── database.svg
│   │   │   │   │   ├── envelope.svg
│   │   │   │   │   ├── globe.svg
│   │   │   │   │   ├── headset.svg
│   │   │   │   │   ├── home.svg
│   │   │   │   │   ├── key.svg
│   │   │   │   │   ├── lock.svg
│   │   │   │   │   ├── server.svg
│   │   │   │   │   ├── sign-in-alt.svg
│   │   │   │   │   └── user-cog.svg
│   │   │   │   ├── paypal-card-selected.svg
│   │   │   │   ├── paypal-card-unselected.svg
│   │   │   │   ├── square-card-selected.svg
│   │   │   │   ├── square-card-unselected.svg
│   │   │   │   ├── stripe-deselected.svg
│   │   │   │   └── stripe-selected.svg
│   │   │   └── resources
│   │   │       └── icons
│   │   │           ├── chart-line.svg
│   │   │           ├── cogs.svg
│   │   │           ├── database.svg
│   │   │           ├── envelope.svg
│   │   │           ├── globe.svg
│   │   │           ├── headset.svg
│   │   │           ├── home.svg
│   │   │           ├── key.svg
│   │   │           ├── lock.svg
│   │   │           ├── server.svg
│   │   │           ├── sign-in-alt.svg
│   │   │           └── user-cog.svg
│   │   ├── images
│   │   │   ├── A57F54F3-2F67-4E92-8E3A-C4F4EDE2CCAB.png
│   │   │   ├── Login.html
│   │   │   ├── NM-DigitalHUB.png
│   │   │   ├── background-hero.png
│   │   │   ├── graphic-design.png
│   │   │   ├── logo-256x256.png
│   │   │   ├── logo-blackandwhite.svg
│   │   │   ├── logo-menu.png
│   │   │   ├── logo-nm.svg
│   │   │   ├── logo-primary.png
│   │   │   ├── logo-retina.png
│   │   │   ├── logo-social.png
│   │   │   ├── logo.png
│   │   │   ├── logo.svg
│   │   │   └── public
│   │   │       └── assets
│   │   │           └── images
│   │   └── logo
│   │       ├── nm-logo-full-color-v1.svg
│   │       ├── ‏nm-icon-color.png
│   │       ├── ‏nm-logo-full-color-v1.png
│   │       └── ‏nm-logo-full-color.png
│   ├── build
│   │   ├── assets
│   │   │   ├── app-Bf4POITK.js
│   │   │   └── app-Bfegd855.css
│   │   └── manifest.json
│   ├── client_secret_825135715735-tlcbc3fjdr21j0k5965i75mn4o0tou11.apps.googleusercontent.com.json
│   ├── css
│   │   └── filament
│   │       ├── filament
│   │       │   └── app.css
│   │       ├── forms
│   │       │   └── forms.css
│   │       └── support
│   │           └── support.css
│   ├── favicon.ico
│   ├── images
│   │   └── logo.svg
│   ├── index.php
│   ├── js
│   │   └── filament
│   │       ├── filament
│   │       │   ├── app.js
│   │       │   └── echo.js
│   │       ├── forms
│   │       │   └── components
│   │       │       ├── color-picker.js
│   │       │       ├── date-time-picker.js
│   │       │       ├── file-upload.js
│   │       │       ├── key-value.js
│   │       │       ├── markdown-editor.js
│   │       │       ├── rich-editor.js
│   │       │       ├── select.js
│   │       │       ├── tags-input.js
│   │       │       └── textarea.js
│   │       ├── notifications
│   │       │   └── notifications.js
│   │       ├── support
│   │       │   └── support.js
│   │       ├── tables
│   │       │   └── components
│   │       │       └── table.js
│   │       └── widgets
│   │           └── components
│   │               ├── chart.js
│   │               └── stats-overview
│   │                   └── stat
│   │                       └── chart.js
│   ├── php_files_list.txt
│   ├── project_tree.txt
│   ├── robots.txt
│   └── svg
│       ├── cloud-solutions-icon.svg
│       ├── domain-registration-icon.svg
│       ├── logo.svg
│       ├── shared-hosting-icon.svg
│       └── vps-hosting-icon.svg
├── readme.markdown
├── rector.php
├── reorganization-plan.md
├── resource-namespace-migration-plan.md
├── resources
│   ├── css
│   │   ├── app.css
│   │   ├── filament
│   │   │   └── theme
│   │   │       └── theme.css
│   │   └── filament-rtl.css
│   ├── docs
│   │   ├── interface-graph.svg
│   │   ├── interface-map.md
│   │   └── interface-relations.json
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── lang
│   │   ├── en
│   │   │   ├── admin.php
│   │   │   └── home.php
│   │   └── he
│   │       ├── admin.php
│   │       ├── auth.php
│   │       ├── home.php
│   │       ├── pagination.php
│   │       ├── passwords.php
│   │       └── validation.php
│   ├── markdown
│   │   ├── Hosting_Dashboard_Specification.md
│   │   ├── policy.md
│   │   ├── terms.md
│   │   └── ‎ NM_DigitalHUB_UI_UX_Tables_Expanded⁩.docx
│   ├── sass
│   │   └── app.scss
│   ├── sassnpm
│   ├── svg
│   │   └── logo.svg
│   └── views
│       ├── Domains.php
│       ├── Hosting.php
│       ├── Search.php
│       ├── Vps.php
│       ├── admin
│       │   └── dashboard.blade.php
│       ├── api
│       │   ├── api-token-manager.blade.php
│       │   └── index.blade.php
│       ├── auth
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── client
│       │   ├── dashboard.blade.php
│       │   ├── modules.blade.php
│       │   ├── pages
│       │   │   └── default.blade.php
│       │   └── statistics.blade.php
│       ├── coming-soon.blade.php
│       ├── components
│       │   ├── action-message.blade.php
│       │   ├── action-section.blade.php
│       │   ├── application-logo.blade.php
│       │   ├── auth-session-status.blade.php
│       │   ├── authentication-card-logo.blade.php
│       │   ├── authentication-card.blade.php
│       │   ├── banner.blade.php
│       │   ├── button.blade.php
│       │   ├── checkbox.blade.php
│       │   ├── confirmation-modal.blade.php
│       │   ├── confirms-password.blade.php
│       │   ├── danger-button.blade.php
│       │   ├── dialog-modal.blade.php
│       │   ├── dropdown-link.blade.php
│       │   ├── dropdown.blade.php
│       │   ├── feature-card.blade.php
│       │   ├── form-section.blade.php
│       │   ├── guest-layout.blade.php
│       │   ├── hosting-plan.blade.php
│       │   ├── input-error.blade.php
│       │   ├── input-label.blade.php
│       │   ├── input.blade.php
│       │   ├── kpi-summary-bar.blade.php
│       │   ├── label.blade.php
│       │   ├── layouts
│       │   │   └── app.blade.php
│       │   ├── logo-with-text.blade.php
│       │   ├── logo.blade.php
│       │   ├── modal.blade.php
│       │   ├── nav-link.blade.php
│       │   ├── navbar.blade.php
│       │   ├── primary-button.blade.php
│       │   ├── responsive-nav-link.blade.php
│       │   ├── search-form.blade.php
│       │   ├── secondary-button.blade.php
│       │   ├── section-border.blade.php
│       │   ├── section-title.blade.php
│       │   ├── switchable-team.blade.php
│       │   ├── text-input.blade.php
│       │   ├── validation-errors.blade.php
│       │   └── welcome.blade.php
│       ├── dashboard.blade.php
│       ├── domains.blade.php
│       ├── emails
│       │   ├── team-invitation.blade.php
│       │   └── template.blade.php
│       ├── filament
│       │   ├── components
│       │   │   └── page-preview-link.blade.php
│       │   ├── custom
│       │   │   └── body-start.blade.php
│       │   ├── pages
│       │   │   └── dashboard-header.blade.php
│       │   ├── resources
│       │   │   ├── generator-resource
│       │   │   │   └── pages
│       │   │   │       └── generate-code.blade.php
│       │   │   └── module-manager
│       │   │       └── pages
│       │   │           ├── ListModuleManagers.php
│       │   │           ├── list-module-managers.blade.php
│       │   │           └── view-component-code.blade.php
│       │   └── widgets
│       │       └── system-health-widget.blade.php
│       ├── home.blade.php
│       ├── hosting.blade.php
│       ├── lang
│       │   └── he
│       │       └── activity.php
│       ├── layouts
│       │   ├── admin.blade.php
│       │   ├── app.blade.php
│       │   ├── client-dynamic-sidebar.blade.php
│       │   ├── client-impersonation-banner.blade.php
│       │   ├── client-layout.blade.php
│       │   ├── client.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── livewire
│       │   ├── admin
│       │   │   ├── dashboard.blade.php
│       │   │   ├── domain-card.blade.php
│       │   │   ├── domains-new.blade.php
│       │   │   ├── domains.blade.php
│       │   │   ├── hosting.blade.php
│       │   │   ├── invoices.blade.php
│       │   │   ├── layout.blade.php
│       │   │   ├── orders.blade.php
│       │   │   ├── plans.blade.php
│       │   │   ├── settings.blade.php
│       │   │   ├── tickets.blade.php
│       │   │   ├── users.blade.php
│       │   │   └── vps.blade.php
│       │   ├── auth
│       │   │   ├── confirm-password.blade.php
│       │   │   ├── forgot-password.blade.php
│       │   │   ├── login.blade.bak
│       │   │   ├── register.blade.php
│       │   │   ├── reset-password.blade.php
│       │   │   └── verify-email.blade.php
│       │   ├── client
│       │   │   ├── dashboard.blade.php
│       │   │   ├── domain-check.blade.php
│       │   │   ├── domains.blade.php
│       │   │   ├── hosting-new.blade.php
│       │   │   ├── invoices.blade.php
│       │   │   ├── settings.blade.php
│       │   │   ├── support-new.blade.php
│       │   │   ├── support.blade.php
│       │   │   └── vps.blade.php
│       │   ├── domains.blade.php
│       │   ├── hosting.blade.php
│       │   └── search.blade.php
│       ├── navigation-menu.blade.php
│       ├── pages
│       │   ├── layouts
│       │   │   ├── default.blade.php
│       │   │   ├── full-width.blade.php
│       │   │   ├── sidebar-left.blade.php
│       │   │   └── sidebar-right.blade.php
│       │   ├── show.blade.php
│       │   └── types
│       │       ├── cloud.blade.php
│       │       ├── domains.blade.php
│       │       ├── home.blade.php
│       │       ├── hosting.blade.php
│       │       ├── legal.blade.php
│       │       └── vps.blade.php
│       ├── policy.blade.php
│       ├── profile
│       │   ├── edit.blade.php
│       │   └── partials
│       │       ├── delete-user-form.blade.php
│       │       ├── update-password-form.blade.php
│       │       └── update-profile-information-form.blade.php
│       ├── terms.blade.php
│       ├── test
│       │   └── test.blade
│       └── vps.blade.php
├── route_management_summary.md
├── routes
│   ├── api.php
│   ├── auth.php
│   ├── console.php
│   ├── test.php
│   ├── web.php
│   └── web_impersonation.php
├── routes.json
├── routes.txt
├── rtl-layout-guidance.md
├── run
├── run-phpstan.sh
├── sanctum_admin_report.txt
├── sanctum_admin_setup.sh
├── scan_code_api.sh
├── scan_invalid_pages.php
├── scan_unregistered_resources.sh
├── scanned_code.json
├── tailwind.config.js
├── tests
│   ├── Feature
│   │   ├── ApiTokenPermissionsTest.php
│   │   ├── Auth
│   │   │   ├── AuthenticationTest.php
│   │   │   ├── EmailVerificationTest.php
│   │   │   ├── PasswordConfirmationTest.php
│   │   │   ├── PasswordResetTest.php
│   │   │   ├── PasswordUpdateTest.php
│   │   │   └── RegistrationTest.php
│   │   ├── AuthenticationTest.php
│   │   ├── BrowserSessionsTest.php
│   │   ├── CreateApiTokenTest.php
│   │   ├── DeleteAccountTest.php
│   │   ├── DeleteApiTokenTest.php
│   │   ├── EmailVerificationTest.php
│   │   ├── ExampleTest.php
│   │   ├── PasswordConfirmationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── ProfileInformationTest.php
│   │   ├── ProfileTest.php
│   │   ├── RegistrationTest.php
│   │   ├── TwoFactorAuthenticationSettingsTest.php
│   │   └── UpdatePasswordTest.php
│   ├── TestCase.php
│   └── Unit
│       └── ExampleTest.php
├── text.log
├── tree.sh
├── unregistered_resources.txt
├── unregistered_resources.zip
├── vite.config.js
├── webhost_backup.zip
├── wrap_migrations.sh
├── zip_file_list_2025-05-12_02-33.txt
└── zip_laravel_project.sh

224 directories, 792 files
```

## File Type Statistics

- **Middleware**: 8 file(s)
- **Models**: 21 file(s)
- **Routes**: 6 file(s)
- **Filament Resources**: 0 file(s)
- **Blade Views**: 66 file(s)
- **Migrations**: 39 file(s)
- **Controllers**: 11 file(s)
- **Livewire Components**: 29 file(s)

