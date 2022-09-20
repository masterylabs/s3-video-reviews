Oauth2 core flow that can be extended to other packages
Can run own Oauth2 from this

AuthFlow
authorize
callback

Example from:
https://stripe.com/docs/connect/oauth-reference

Step 1: START the flow:
Authorize GET
https://connect.stripe.com/oauth/authorize
?response_type=code&client_id={{CLIENT_ID}}&scope=read_write&redirect_uri=https://sub2.example.com

Responsend
code
scope (optional: depending on what was passed in the auth)
state

Complete the connection and get the account ID
POST https://connect.stripe.com/oauth/token
grant_type
code or refresh_token

Response:
access_token

Revoke the account’s access
POST https://connect.stripe.com/oauth/deauthorize
