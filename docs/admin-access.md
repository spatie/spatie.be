# Admin access

The admin requires a verified `@spatie.be` Google sign-in and an approved address.
Customer password and GitHub login still work, but cannot establish an admin session.
The existing `is_admin` flag continues to control staff benefits and API access; it
does not grant panel access.

## Deployment

1. Configure `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` in the deployment's secret
   settings. Register `https://spatie.be/admin/auth/google/callback` as an authorized
   redirect URI on that Google OAuth client. For other environments, set
   `GOOGLE_ADMIN_CALLBACK_URL` to their registered callback URL.
2. Run the migrations. The new `admin_accesses` table intentionally starts empty.
   No existing customer or technical account automatically receives access.
3. Explicitly grant the first approved address with
   `php artisan admin:grant-access person@spatie.be`, replacing the address with
   the intended administrator. This is also the recovery command if necessary.
4. Refresh application/route caches and restart long-running workers as usual.
   Old workers must be drained because they still enforce the old access rules.
5. Sign in through `/admin/login` with the approved Google account. Smoke-test
   the full Google redirect and callback on the deployed environment.

An approved address does not need an existing customer account. Its first verified
Google login reuses an account with the same email, or creates one with a random
password. This does not grant admin access to existing password or GitHub sessions.
The Google subject is bound to the approval on first use. A later subject mismatch
is denied; remove and re-add the approval only after verifying a legitimate account
replacement.

## Managing access

Use **Team / Admin access** to add or remove Spatie addresses. Adding an address
sends no email. All approved administrators have full panel access, including
managing this list. The last approved address cannot be removed.

Revocation is checked on each panel request, including Livewire actions and blog
previews. Removing approval leaves the regular customer account intact. Existing
password, GitHub, and remember-cookie logins require a fresh Google sign-in to
enter the admin, even if their email is approved.

While impersonating a customer, the administrator's Google proof cannot authorize
the impersonated account. Returning restores the original user, but the panel still
checks their current approval and identity. A revoked administrator cannot return
to the panel. Logout or another normal login clears the Google proof.
