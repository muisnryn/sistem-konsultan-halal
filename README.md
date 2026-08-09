<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
spk-halal
├─ .editorconfig
├─ .npmrc
├─ app
│  ├─ Enums
│  │  ├─ JenisPengajuan.php
│  │  ├─ PaymentStatus.php
│  │  └─ ProjectStatus.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ AdminCertificateController.php
│  │  │  ├─ AdminConsultantController.php
│  │  │  ├─ AdminCriteriaController.php
│  │  │  ├─ AdminDashboardController.php
│  │  │  ├─ AdminSpkController.php
│  │  │  ├─ AdminUserController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ ClientDashboardController.php
│  │  │  ├─ ClientDocumentController.php
│  │  │  ├─ ClientPaymentController.php
│  │  │  ├─ CompanyProfileController.php
│  │  │  ├─ ConsultantProjectController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ FinanceProjectController.php
│  │  │  ├─ ProfileController.php
│  │  │  ├─ ProjectController.php
│  │  │  └─ ServiceTypeController.php
│  │  ├─ Middleware
│  │  │  ├─ CheckRole.php
│  │  │  └─ EnsureProfileCompleted.php
│  │  └─ Requests
│  │     ├─ Auth
│  │     │  └─ LoginRequest.php
│  │     └─ ProfileUpdateRequest.php
│  ├─ Models
│  │  ├─ CompanyProfile.php
│  │  ├─ Consultant.php
│  │  ├─ ConsultantEvaluation.php
│  │  ├─ Criteria.php
│  │  ├─ Payment.php
│  │  ├─ Project.php
│  │  ├─ ProjectDocument.php
│  │  ├─ ServiceType.php
│  │  └─ User.php
│  ├─ Providers
│  │  └─ AppServiceProvider.php
│  ├─ Services
│  │  └─ PrometheeService.php
│  └─ View
│     └─ Components
│        ├─ AppLayout.php
│        └─ GuestLayout.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_07_19_121957_create_company_profiles_table.php
│  │  ├─ 2026_07_19_122310_create_consultants_table.php
│  │  ├─ 2026_07_19_122315_create_service_types_table.php
│  │  ├─ 2026_07_19_122320_create_projects_table.php
│  │  ├─ 2026_07_19_122512_create_payments_table.php
│  │  ├─ 2026_07_19_122604_create_project_documents_table.php
│  │  ├─ 2026_07_19_171229_create_criterias_table.php
│  │  └─ 2026_07_19_171231_create_consultant_evaluations_table.php
│  └─ seeders
│     ├─ ConsultantSeeder.php
│     ├─ CriteriaSeeder.php
│     ├─ DatabaseSeeder.php
│     ├─ ProjectSeeder.php
│     ├─ ServiceTypeSeeder.php
│     └─ SpkTestingSeeder.php
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  └─ app.js
│  └─ views
│     ├─ admin
│     │  ├─ certificate
│     │  │  └─ upload.blade.php
│     │  ├─ consultant
│     │  │  ├─ evaluations.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ partials
│     │  │     ├─ drawer.blade.php
│     │  │     ├─ header.blade.php
│     │  │     ├─ stats.blade.php
│     │  │     └─ table.blade.php
│     │  ├─ criteria
│     │  │  └─ index.blade.php
│     │  ├─ dashboard.blade.php
│     │  ├─ master
│     │  │  ├─ services-partials
│     │  │  │  ├─ card.blade.php
│     │  │  │  └─ modal-edit.blade.php
│     │  │  ├─ services.blade.php
│     │  │  ├─ users-partials
│     │  │  │  ├─ modal-create.blade.php
│     │  │  │  ├─ modal-edit.blade.php
│     │  │  │  ├─ table.blade.php
│     │  │  │  └─ toolbar.blade.php
│     │  │  └─ users.blade.php
│     │  └─ spk
│     │     ├─ index.blade.php
│     │     └─ recommend.blade.php
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ client
│     │  ├─ certificate
│     │  │  └─ index.blade.php
│     │  ├─ consultant_info.blade.php
│     │  ├─ dashboard.blade.php
│     │  ├─ documents
│     │  │  └─ index.blade.php
│     │  ├─ payment
│     │  │  └─ index.blade.php
│     │  ├─ profile.blade.php
│     │  ├─ project
│     │  │  ├─ create.blade.php
│     │  │  └─ success.blade.php
│     │  └─ status_sertifikasi.blade.php
│     ├─ components
│     │  ├─ application-logo.blade.php
│     │  ├─ auth-session-status.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ dropdown-link.blade.php
│     │  ├─ dropdown.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ nav-link.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ responsive-nav-link.blade.php
│     │  ├─ secondary-button.blade.php
│     │  └─ text-input.blade.php
│     ├─ consultant
│     │  ├─ assignments
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ dashboard.blade.php
│     │  ├─ documents
│     │  │  ├─ index.blade.php
│     │  │  └─ validate.blade.php
│     │  ├─ reports
│     │  │  └─ index.blade.php
│     │  └─ schedules
│     │     ├─ calendar.blade.php
│     │     └─ index.blade.php
│     ├─ dashboard.blade.php
│     ├─ finance
│     │  ├─ dashboard.blade.php
│     │  ├─ invoices
│     │  │  └─ index.blade.php
│     │  ├─ payments
│     │  │  ├─ index.blade.php
│     │  │  └─ pdf.blade.php
│     │  ├─ project
│     │  │  └─ edit.blade.php
│     │  └─ reports
│     │     └─ index.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ guest.blade.php
│     │  └─ navigation.blade.php
│     ├─ profile
│     │  ├─ edit.blade.php
│     │  └─ partials
│     │     ├─ delete-user-form.blade.php
│     │     ├─ update-password-form.blade.php
│     │     └─ update-profile-information-form.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  │  └─ documents
│  │  │     ├─ audit_reports
│  │  │     │  ├─ hx7ZOGYla8NtdToiiyrwWDbFKXgPjtXsw0oSl9i6.pdf
│  │  │     │  ├─ sample_pdf.pdf
│  │  │     │  └─ spZJgQv8QAkqpyFr1W9i4oUODZGo3a17xBcKq02C.pdf
│  │  │     ├─ certificates
│  │  │     │  ├─ b04jKB7ahuCQciMCoL7gjBfFNTmCbuAp0Aca8ygU.pdf
│  │  │     │  ├─ IQqZfqJaHXC0gkyoftnvKUAuFpjBCYkfWgU2TsPt.pdf
│  │  │     │  ├─ sample_pdf.pdf
│  │  │     │  └─ xTuPZCLqGt9r1P1s58JgofyDvB9DPnmhGG1ySTYH.pdf
│  │  │     ├─ nib
│  │  │     │  └─ igpTkvrYfIqeC07fF00pTbfA19w254tIXcqZxGz4.pdf
│  │  │     ├─ npwp
│  │  │     │  └─ gxWXimLeCBDOe47n6UI14cqfFiqhv3OKLZg2Pz3V.pdf
│  │  │     ├─ penawaran
│  │  │     │  ├─ 21NuzZyLsbld62diLNQh8X0NF9UZnt2A6tbjkoZR.pdf
│  │  │     │  ├─ 9W9NeZrIYNfWzdEfqnQdOcZFjtcbIHhemhwfWkoz.pdf
│  │  │     │  ├─ R1GbNeXvQYVDHnuxAv8HAxfaRnQwaUjm5mB86ND0.pdf
│  │  │     │  └─ ug9Y1iUzcuDCaXQZkeNpKsP1d7Z6s2UuwlTrSBUz.pdf
│  │  │     └─ requirements
│  │  │        ├─ 2kNZOaw69R24HV2QN775J6cxjehMrjNr08UphUbZ.xlsx
│  │  │        ├─ 3S8lJ46AXisp73SYmmUynnwE8mdI2T9lckFMmxwV.pdf
│  │  │        ├─ aqi8qDPsuO7XPec7uii0GqvOHepVgZdXGHtGIUYR.xlsx
│  │  │        ├─ d4lCPj2xPrvTXTuYdixizs2HZAL9YlSDPkrLSkN1.xlsx
│  │  │        ├─ evXczBkPlykLCklB07WAPieCem0sjsX5cMGuRNaz.xlsx
│  │  │        ├─ fOXGlbN6gLkCmO9IabACB8nyD5JiVehPSQaD30AJ.pdf
│  │  │        ├─ GOdUMjGPDXncNiJEIC3NPEGiTYIrFqNVsTKXrPxt.xlsx
│  │  │        ├─ Ho106JhwNXEtDzHhu1wcDaXSjD3N3qppKYuBa79A.pdf
│  │  │        ├─ iJElfm4qtQwwGqQWDI8V0kNMebr5tzNuHs89g5W2.xlsx
│  │  │        ├─ ijXlzqWvD8BYMpsVSo2ZBmVF3COmHTIJPJT9juRx.xlsx
│  │  │        ├─ ojQ0imABBU4pA78RIAToXqcPbahoblwKhrMXf2NL.xlsx
│  │  │        ├─ pPMoYaHio1xfDcfP8Z3O1VC1UNvrPKcaOU5xOobe.xlsx
│  │  │        ├─ sample_excel.xlsx
│  │  │        ├─ sample_pdf.pdf
│  │  │        ├─ tfCYqxYyIXTQG0fGOsIlrYZJXNT7mRzpExWzJlmW.pdf
│  │  │        ├─ uO7Bm6zwhKMUzLHc62lVvoF8bjzZOySta8kFI194.pdf
│  │  │        └─ VmQE1Ydu4qDvsxXgFPXchnAvjzbQrPANC264dvNk.pdf
│  │  └─ public
│  │     └─ documents
│  │        ├─ audit_reports
│  │        │  └─ sample_pdf.pdf
│  │        ├─ certificates
│  │        │  └─ sample_pdf.pdf
│  │        ├─ nib
│  │        │  ├─ GVzLFhsIKVdDJ5oMn3f5LqVrhogD5CqlvQ00a4uI.pdf
│  │        │  ├─ MRXNsBxxCXjr4fOoouPqzbJ95A0e0wepKfn6ndLG.pdf
│  │        │  ├─ o6Zz0nB5cOOj9I8dde3wIeCibKq7sGZfV07D9kz5.pdf
│  │        │  ├─ P5n7oZKLLkIhB7Hhh1pogVsVv4MHBbqTvrrTZdzx.pdf
│  │        │  ├─ q5SZvY9cBXYRfR8jOJRziI262GNIuUVRFdA9evtz.pdf
│  │        │  └─ yQsIeFzgv3wa8BPTfOPwjYDUCFeQuTkvmouUlsH2.pdf
│  │        ├─ npwp
│  │        │  ├─ anxLxS6Xc2V5QpfA6WqcN35HKHiva3zCdWmklXzX.pdf
│  │        │  ├─ mUz13mi9MjUeJ2XuJo3c8WMdYFM5Bwir8ni1FOlY.pdf
│  │        │  ├─ SRO1f2zmF4cF0ZigWb4G23CAzfyzGzujNKMKMceo.pdf
│  │        │  ├─ vntWGnrcqtrTe10Y95QpmPdEaRpx2UExkfjfkOFK.pdf
│  │        │  ├─ ZwH1AM2SxyHTf8MAU84Jf3D8f901CZjKBt2Yud9v.pdf
│  │        │  └─ ZzUZiwFvfEVdpdpgNCD4mchts5jkNCooChluT5qF.pdf
│  │        ├─ penawaran
│  │        │  ├─ 1u5l1HHzRiK1NSswolRhLbrTC5SdfMfkqMIzzJB4.pdf
│  │        │  ├─ EKRvf8XtyvOxFxLTaTRM8QPGldjPNf1tPFgrMcDW.pdf
│  │        │  ├─ sample_penawaran.pdf
│  │        │  └─ z4iETLDCBIcgJhpV5flDJT9S0B3RNqfmRvJ2FnqL.pdf
│  │        └─ requirements
│  │           ├─ sample_excel.xlsx
│  │           └─ sample_pdf.pdf
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 00732b0099e4996e5d7b74b002eecb9b.php
│  │     ├─ 031b6f5b2ffa27b8d4da27da8dd23e9b.php
│  │     ├─ 0504b5c54afd5cafe882fb9f470051ff.php
│  │     ├─ 06288d7842ef0009dfc24f42d36fe903.php
│  │     ├─ 0801b397cd3fe24b07e9cd5cab34de73.php
│  │     ├─ 088ec4dd877013e9d5e2351334789017.php
│  │     ├─ 0a07bb27cea7229541aa757e2ab5e512.php
│  │     ├─ 0a4d0e1713f4e46a8eade92d3aa07ce0.php
│  │     ├─ 0f35ef46d119559039c6f61fc6e64219.php
│  │     ├─ 18d0c40f6b2e7d4ce35c820f39ad3a75.php
│  │     ├─ 1b37ff2719f45a23e25940955f281944.php
│  │     ├─ 1d0841cbc27a61a6881bad25785d2bd3.php
│  │     ├─ 1d41f78aa3b2ef4b09bd347c79d650cb.php
│  │     ├─ 2106dbc2f12936ba18ec2571bd8d9556.php
│  │     ├─ 213ddaef776eeaef9257e185076db19c.php
│  │     ├─ 2aac69858d9c25c98d6ff536cd95a82f.php
│  │     ├─ 2c6d1089768a5e3915f1bdaf38ca674a.php
│  │     ├─ 2e41ee803bf0b9225c8a1c9f256cb912.php
│  │     ├─ 2e52078109c048444428a4544b218fe1.php
│  │     ├─ 2eddd2c89746d110bb067e8c3bcf2a2b.php
│  │     ├─ 2f894b804054a6e780112568c0a1965e.php
│  │     ├─ 2fb588f7c0f5f7a0af3b874547f3012d.php
│  │     ├─ 30069055ab69d90277e85933ba7794ca.php
│  │     ├─ 3370ca86d26d90819231d951fcb130d4.php
│  │     ├─ 33d5017ff23a5cf954c0c7ba75ae0455.php
│  │     ├─ 366e5e998a84b542c89edf410274da8c.php
│  │     ├─ 36a417316eb24980ce7fa9f5ed0b8ae1.php
│  │     ├─ 38bdbbe00b1cc5382a95b03cb705e747.php
│  │     ├─ 39419cbcc0cf7beb43124bcecf17f98c.php
│  │     ├─ 3bee2d633fb4046d0195a9283fccec0d.php
│  │     ├─ 3e2206e39c9f4b63035077358ab92a37.php
│  │     ├─ 3fd95a34771d771c6ffbe25c7959c977.php
│  │     ├─ 425bf3e84ba855fccda5d87def701903.php
│  │     ├─ 476a35052449ec0197956679fc6837ff.php
│  │     ├─ 538273ba55a7e1a6da266c15a54eafab.php
│  │     ├─ 54f7ab32e976aedddf5ea954a2f38fa3.php
│  │     ├─ 55e6b3b2270eab2910323ad123056861.php
│  │     ├─ 5638e8558bb9ed0805e3a137e34d56c8.php
│  │     ├─ 5f02af98d8adcf00e5fa4378bf50ba31.php
│  │     ├─ 63108cdd40b90e7466ab9cbda9c7627b.php
│  │     ├─ 677e260995b690e1a61ddd3eaeecb8b5.php
│  │     ├─ 688189075429823538010959b22781ae.php
│  │     ├─ 6a5a6debff44e39cde3ecc5893f5ae38.php
│  │     ├─ 6ded07dcec601f760e3fd51434666ca6.php
│  │     ├─ 6ee8b345ec1706bdfaafbff4af9e3da4.php
│  │     ├─ 76cf046e0b52d739c0dc4cd7bdc522f1.php
│  │     ├─ 77a5a49964d875b82f211d8c88e52c02.php
│  │     ├─ 791e71bc605ba8af2d21acdfdd454019.php
│  │     ├─ 7a1b5aa9c9a2dd4ebf344fdba2b7c57f.php
│  │     ├─ 7f17b158ea1e1ae42f3bd9b249955b69.php
│  │     ├─ 83b85fabff6574217abc0432890a1bbc.php
│  │     ├─ 841faedf2aa3bf90c895f87eed1e8626.php
│  │     ├─ 84ee22834720e3fce31d6528a98062e3.php
│  │     ├─ 860f45f3ed70deffdfdd2633b3691365.php
│  │     ├─ 871c4a8ac43da217d64e958a58f73034.php
│  │     ├─ 87ac977eb74f122382bca0db201d3f9a.php
│  │     ├─ 87ec7e2e04638cfbccedfac3812a3cfe.php
│  │     ├─ 9035e16eed77a2be8f595bfd1720a684.php
│  │     ├─ 95725071dc3ac56f3945cbc3aadc7504.php
│  │     ├─ 96f3e9dbbc924460bc27a0ffc31c5fc6.php
│  │     ├─ a1b7c6dd806bc7aa1059e67ad77b5aa7.php
│  │     ├─ a3d2efbbaadb31f4becc33d9a47e15f7.php
│  │     ├─ a6ff2c1a444a7254d07217cbf86a339e.php
│  │     ├─ a7768e888651e26ffcb17c12f198bbbb.php
│  │     ├─ a8fa44e3ef45151f798aed9b484a5c4f.php
│  │     ├─ ad00e602c7a254de92535baf08ea78de.php
│  │     ├─ b036c751ba4810ca8a5884d5aa604a43.php
│  │     ├─ b09f9e27b5280b0d316b99e2ace49f26.php
│  │     ├─ b10c4c609ac6351d0a0745f251633bca.php
│  │     ├─ b44af789f3bd775ca75759373b01fc7f.php
│  │     ├─ b6938c2b671d85ab152cbae1ed041fa3.php
│  │     ├─ b6972820fbde32d2bdd7e217fa53d217.php
│  │     ├─ b8d9d47d73bcb6e6da3995a447f338fd.php
│  │     ├─ bacbea1021346b5a84b273563ccf6f71.php
│  │     ├─ bc06f8d649af6e0798b10cb032f6dfea.php
│  │     ├─ bdbcb488996563e3921c6c07a807a0e9.php
│  │     ├─ c0ad87ead2e83c9e64c28b60ba8a8ff2.php
│  │     ├─ c4c615ddec631420f30bb070b60679b2.php
│  │     ├─ c86010db039b9335efdced5bcc169ef8.php
│  │     ├─ cb3ff09ae694747b3ad72b4ea7644346.php
│  │     ├─ cb853f8ddcc0783e13037f9a9a6a456d.php
│  │     ├─ cd6ff9723b7a2d50acde5d1c4b8e9c57.php
│  │     ├─ d190f878a2241d2eacc81a8adfade970.php
│  │     ├─ d6bb1df3ac02b477b1fdfa653aa93ce0.php
│  │     ├─ d72b4365565afba0cb09aef954435c00.php
│  │     ├─ d8076e7b575b61259d4aa42b7800abe9.php
│  │     ├─ dc241fe0be287d3aa0ef604359c4426c.php
│  │     ├─ dcd9f5e3a161758756a5ba4138e7b823.php
│  │     ├─ dd63c45ef65d6db34ad19933a010e19d.php
│  │     ├─ ddf36b646834f390273b05e86c505c6e.php
│  │     ├─ df52251f450e2d6f7644b511faedba9e.php
│  │     ├─ dfa508bd270ab285539c798e9c8c57cb.php
│  │     ├─ e3af9bf8b63bf682114b03d5e0b6cdfd.php
│  │     ├─ e5eb73720e8f4cc06eba25f4050539f5.php
│  │     ├─ e6396df150f667fd9de0d4e672897422.php
│  │     ├─ e67c2b2b0be3ce138e48117241ea7428.php
│  │     ├─ e6c15af7521cc5acb9a4d2d9b865a158.php
│  │     ├─ e82d8d83c53680f766167632bc5eae44.php
│  │     ├─ ec3bf5633613df00f9fbe1b2c8d87acd.php
│  │     ├─ ef7d0ae97d5fee184079bd308b464d88.php
│  │     ├─ f4e48e0d26df213cde2e1fd783417802.php
│  │     ├─ fb660bcfaf560814772e372ecb6bb954.php
│  │     ├─ fd2a9e17e10c333d9a0278b9fe0400d6.php
│  │     ├─ fd7594b8a792dd5ea1a61c8383bb52ab.php
│  │     └─ fe171341cc10d03532f440c560047b6a.php
│  └─ logs
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  ├─ ExampleTest.php
│  │  └─ ProfileTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```