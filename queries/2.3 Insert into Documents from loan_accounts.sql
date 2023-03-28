TRUNCATE TABLE documents;
INSERT INTO documents
(loan_account_id,
date_release,
promissory_number,
created_at,
updated_at
)
(
SELECT
loan_accounts.loan_account_id,
loan_accounts.date_release,
loan_accounts.account_num,
loan_accounts.created_at,
loan_accounts.updated_at
FROM
loan_accounts
)