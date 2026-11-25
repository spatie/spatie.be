# Admin access

The admin requires a verified `@spatie.be` Google sign-in and an approved address.
Customer password and GitHub login still work, but cannot establish an admin session.

`User::isAdmin()` checks the current allowlist for a trusted binding to the user's
ID and normalized `@spatie.be` email. Registration and profile edits cannot create
or transfer that binding. API authorization uses this method without requiring a
browser session. Staff benefits still require a matching team member as well.
Filament adds Google session and identity checks through `canAccessPanel()`.

The migration binds only the intersection of existing allowlisted addresses and
accounts that already had `users.is_admin = true`, then removes that column. It
does not add addresses to the allowlist or trust other email-matched customers.
Seeded customer accounts do not receive admin access automatically either.

## Deployment

1. Configure `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` in the deployment's secret
   settings. Register `https://spatie.be/admin/auth/google/callback` as an authorized
   redirect URI on that Google OAuth client. For other environments, set
   `GOOGLE_ADMIN_CALLBACK_URL` to their registered callback URL.
2. Run the migrations. On a fresh installation, `admin_accesses` starts empty.
   On upgrade, previously flagged staff accounts retain access only if their
   address is already approved. Other existing customer accounts require the
   recovery procedure below before they can sign in to the admin.
3. Explicitly grant the first approved address with
   `php artisan admin:grant-access person@spatie.be`, replacing the address with
   the intended administrator. This is also the recovery command if necessary.
4. Refresh application/route caches and restart long-running workers as usual.
   Old workers must be drained because they still enforce the old access rules.
5. Sign in through `/admin/login` with the approved Google account. Smoke-test
   the full Google redirect and callback on the deployed environment.

An approved address does not need an existing customer account. Its first verified
Google login creates an account with a random password and binds its ID and Google
subject to the approval. An already-bound account is reused. An unbound existing
customer account is never adopted automatically, even after Google verification:
an attacker may have registered it and retained its password, GitHub login, sessions
or API tokens. The login stops with an account-conflict message instead.

This does not grant panel access to existing password or GitHub sessions. A later
Google subject mismatch is denied; remove and re-add the approval only after
verifying a legitimate account replacement.

## Recovering an existing trusted account

An operator with Laravel Cloud command access can explicitly bind an independently
verified existing account with `php artisan admin:grant-access person@spatie.be --user-id=123`,
replacing both values. The command validates that the ID and email
belong to the same account, is idempotent, and will not replace another binding.
It is available even when no administrator can currently enter Filament.

Before using this override, verify the local account's ownership through a trusted
channel, including its existing password, linked GitHub account, sessions and API
tokens. Matching the claimed email or seeing a successful Google login is not
enough to trust old credentials. Do not bind a suspected preclaimed account; resolve
its ownership first. The command deliberately does not reset credentials, delete
customer data or merge accounts.

Removing and re-adding an approval does not bypass this check for an existing
customer. After recovering the account, sign in through Google as usual.
When moving a bound account to another email, remove its original approval before
binding the new address. Each user ID can have only one approval.

## Managing access

Use **Team / Admin access** to add or remove Spatie addresses. Adding an address
sends no email. All approved administrators have full panel access, including
managing this list. The last approved address cannot be removed.

Deleting a customer account clears its local user-ID binding but retains the
approved address and any bound Google subject. Only that verified Google identity
can create and bind a replacement account; another customer claiming its email
still receives no staff privileges.

Revocation is checked on each panel request, including Livewire actions and blog
previews, and on each admin API request, including requests using existing tokens.
Removing approval also removes the staff benefits that depend on it, but leaves
the regular customer account and purchases intact. Existing password, GitHub, and
remember-cookie logins require a fresh Google sign-in to enter the admin, even if
their email is approved.

While impersonating a customer, the administrator's Google proof cannot authorize
the impersonated account. Returning restores the original user, but the panel still
checks their current approval and identity. A revoked administrator cannot return
to the panel. Logout or another normal login clears the Google proof.
