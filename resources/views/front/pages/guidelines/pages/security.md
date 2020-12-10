---
title: Security
description: There's no key under the mat
weight: 5
---

This section of the guidelines documents some of our best practices to work securely.

## Passwords

- All passwords should be stored in 1Password
- All passwords should be unique, no password may be reused
- Two-factor authentication (via 1Password) should be used if a service provides that

## Applications

- All HTTP traffic should be sent over SSL
- All forms should use a CSRF token to prevent cross site
- Routes performing a significant action (delete, update, ...) should use the appropriate HTTP method (`DELETE`, `POST`, `PUT` - not `GET`)
- When a site uses authorization/authentication, automated tests should be added to test only authorized users can use certain functionality

## Database

- All stored passwords should be hashed
- All API keys stored in the database should be encrypted
- A separate database user should be used for every database, preferably with relevant read/write permissions
- Ideally the database is only accessible from whitelisted hosts (from the webserver and developers)

## Servers

- Should use the latest versions of NGINX, PHP, Ubuntu, etc...
- Should use SSH with private key authentication, password authentication is disabled
- `unattended-upgrades` package should be installed and enabled for security updates
- Firewall should be configured to only allow relevant traffic (generally ports 22 and 443)
- Are all available from Ansible for quickly patching issues or removing access for a public key

## Misc

- Use BackBlaze to backup your computer. Every few months, make sure that it works
- Every private key must be protected by a password
- All Macs should have FileVault enabled
- Do not use public searchable services like Pastebin or gist to share sensitive code or data
- Do not install any pirated software on your Mac or phone
- Do not use any browser extensions that can track typed keys, passwords or browser history
