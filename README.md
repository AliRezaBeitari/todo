## TODO
This is the back-end for my Android course project (مباحث ویژه ۱)

## Screenshot
![Screenshot](screenshot.png)

## Register
Register (signup) a new user.

**URL:** `/api/register`

**Method:**: `POST`

**Auth Required:** `NO`

**Data Constraints:**

```json
{
    "name": "AliReza Beitari",
    "email": "beitari.alireza@gmail.com",
    "password": "123456789",
    "password_confirmation": "123456789"
}
```

### Properties

| Property | Type | Limits | Description |
|:---------|:-----|:------:|-------------|
| **name**   | String | required, max:255 | The name of the user |
| **email** | String | email, max:255, unique | A valid email address for the user |
| **password** | String | min:8 | The password of the user in plaintext |
| **password_confirmation** | String | min:8, equal to `password` | The password confirmation |


### Response
```json
{
    "ok": true,
    "api_token": "gMgQmFrcvoolN2uce30mXjnbM..."
}
```

### Properties

| Property | Type | Description |
|:---------|:-----|-------------|
| **ok**   | Boolean | Just indicates that user is registered |
| **api_token** | String | A unique random string with the length of 80 |