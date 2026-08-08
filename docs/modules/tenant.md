# Tenant Management

## Purpose

A tenant represents a client/company using Kodal Management System.

Kodal is a multi-tenant platform. Each tenant has isolated business data and configuration.

## Tenant Fields

- id
- name
- slug
- legal_name
- email
- phone
- address
- logo_path
- timezone
- currency
- locale
- status
- settings
- created_at
- updated_at

## Tenant Status

Supported statuses:

- active
- suspended

### Active

The tenant can access the system normally.

### Suspended

The tenant cannot access normal business operations.

Suspension may be used for:

- Account administration
- Subscription issues
- Security incidents
- Client-requested suspension

## Business Rules

1. Every tenant must have a unique name within the platform.
2. Every tenant must have a unique slug.
3. A tenant must have a status.
4. New tenants are created with `active` status by default.
5. Suspended tenants cannot perform normal business operations.
6. Tenant business data must be isolated from other tenants.
7. Users must only access tenants they are assigned to.
8. Tenant configuration must not affect other tenants.
9. Tenant branding belongs to the tenant and may include its own logo and company information.
10. Tenant records should not be physically deleted during normal operations.
11. Tenant deletion should be treated as an administrative operation and require additional safeguards.

## Multi-Tenancy Rule

Every tenant-owned business record must contain a `tenant_id`.

Example:

products
- tenant_id

warehouses
- tenant_id

branches
- tenant_id

sales
- tenant_id

purchasing records
- tenant_id

stock movements
- tenant_id

A user must never be able to access another tenant's records by modifying an ID or request parameter.

## Branding

Each tenant may configure:

- Company name
- Logo
- Contact information
- Default locale
- Default currency
- Timezone

The tenant's branding should be displayed throughout the client-facing interface.

## Future Considerations

Possible future tenant configuration:

- Subscription plan
- Enabled modules
- Feature flags
- Tax configuration
- Fiscal settings
- Invoice settings
- Numbering configuration
- Notification settings