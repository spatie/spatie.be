---
title: Working securely
description: No keys under the mat.
weight: 5
---

These are the practices that keep our accounts, devices and infrastructure safe, and how we handle vulnerabilities and incidents. For writing secure Laravel code, see [Secure coding](/guidelines/secure-coding).

## Passwords and accounts

- Store all passwords in 1Password
- Every password must be unique, never reuse a password
- Enable two-factor authentication on every service that supports it. Prefer passkeys or an authenticator (1Password) over SMS
- Protect every SSH key with a passphrase, or keep it in the [1Password SSH agent](https://developer.1password.com/docs/ssh/agent/)
- Use fine-grained GitHub personal access tokens, limited to the repositories they need, with an expiration date
- When someone leaves the team, suspend their Google Workspace account first. That closes every app and service that uses Google login. On the same day, revoke access to everything else: GitHub, 1Password, Forge, Laravel Cloud, SSH keys on servers, and any API tokens they created

## Single sign-on

Local accounts are easy to forget when someone leaves. Google login means there's only one account to disable.

- Internal applications we build, like admin panels and internal tools, must use Google login restricted to our Google Workspace domain. They don't have local passwords. See [Secure coding](/guidelines/secure-coding) for how to set this up
- For third-party services, use Google login whenever it is available, instead of creating a separate account with a password
- Suspending a Google account doesn't end sessions that are already active. Keep session lifetimes of internal applications short, and don't offer "remember me"

## Devices

- Enable FileVault on all Macs
- Install operating system and browser updates as soon as they are available
- Lock your screen when you leave your computer
- Do not install any pirated software on your computer or phone
- Do not use publicly searchable services like Pastebin or gists to share sensitive code or data
- Browser extensions can read everything you do in your browser. Only install them from your browser's official extension store and use as few as possible. Extensions may change ownership or be taken over by malicious actors. Do not use extensions that can track typed keys, passwords or browsing history. The 1Password extension is fine

## GitHub

- All commits should be [signed](https://docs.github.com/en/authentication/managing-commit-signature-verification/signing-commits). Here are the steps to [set it up using 1Password](https://blog.1password.com/git-commit-signing/)
- Protect the `main` branch of live projects and packages, so it can't be force pushed or deleted
- Enable secret scanning and push protection, so leaked credentials are caught before they end up in the history

## AI tools

We use Claude Code (Anthropic) and Codex (OpenAI).

- Only use them through your Spatie account, never through a personal account. Personal plans may use your conversations to train models
- Never paste secrets, customer data or production database dumps into an AI tool
- Coding agents read files and run commands with your permissions. Don't keep production `.env` files or other production credentials where an agent can read them
- Only let an agent run commands without asking for approval when it can't reach anything you wouldn't want it to change
- Treat MCP servers, skills and plugins like dependencies. They run with your permissions, so only install them from sources you trust

## Servers

Our applications run on Laravel Cloud, or on servers provisioned with Forge or Ansible.

On Laravel Cloud, the platform keeps the operating system and services patched. You're still responsible for the environment variables, and for who has access to the organization. Give team members the least privileged role they need.

Servers we manage ourselves:

- Should run versions of PHP, NGINX, MySQL and Ubuntu that still receive security updates
- Should have the `unattended-upgrades` package installed and enabled for security updates
- Should only allow SSH with private key authentication. Password authentication is disabled
- Should have a firewall that only allows relevant traffic (generally ports 22, 80 and 443). Restrict port 22 to known IP addresses when possible
- Should be managed through Forge or Ansible, so we can quickly patch issues or remove access for a public key

## Databases

- Use a separate database user for every application, with only the permissions it needs
- Databases should not be publicly accessible. Only allow connections from the application servers and, when needed, from allowlisted IP addresses
- Backups should be encrypted. Regularly verify that you can restore them

## Reporting a vulnerability

If you discover a security issue in one of our packages or applications, please email [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

When we receive a report about one of our packages, we:

1. Confirm that we received it, and verify the issue
2. Fix it in a private [GitHub security advisory](https://docs.github.com/en/code-security/security-advisories/working-with-repository-security-advisories/creating-a-repository-security-advisory)
3. Tag a release with the fix
4. Publish the advisory, request a CVE when appropriate, and credit the reporter

## Security incidents

A security incident is an emergency, so everything on the [Emergencies](/guidelines/emergencies) page applies, including taking the application down when data is exposed. In addition:

- Rotate every secret that might be compromised: `APP_KEY`, database passwords, API keys and tokens
- Invalidate sessions and API tokens when accounts might be compromised
- Preserve logs before cleaning anything up, you'll need them to find out what happened
- Inform the team lead immediately. When personal data is involved, the breach may need to be reported to the data protection authority within 72 hours

## Writing secure code

Most security issues are prevented while writing code, not after deploying it. Our [Secure coding](/guidelines/secure-coding) guidelines cover how we handle authentication, authorization, user input, file uploads, dependencies and secrets in our Laravel applications and packages.
