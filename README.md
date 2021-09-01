# Modernyze
Modernyze is a application that helps you build update servers for your application. 
It comes with a REST api for not only quering product versions, but also for downloading and verifying them.  
## Installation
### 1st Step
Clone or download the repo and run composer:
```bash
git clone https://github.com/joonlabs/Modernyze.git
composer install --no-dev
```
### 2nd Step
Create a `.env` file in the project root, just like the `.env.example` file.
Inside this file you need to define your `SERVING_DIRECTORY`, which is the path to your products:
```dotenv
SERVING_DIRECTORY="./resources"
```
**Hint:** Inside your products you should use the following directory structure to enable Modernyzes' automatical serving:
```
└── servingDir
  ├── productOne
  | ├── v1.0.0.zip
  | ├── v1.0.1.zip
  | └── v2.0.0.zip
  ├── productTwo
  | ├── v1.0.0.zip
  | └── ...
  └── ...
```

### 3rd Step
Run the setup script - This will create the database and also migrate it.
```bash
php buddy setup
```

### 4th Step
Generate new credentials for api use.
```
php buddy modernyze:generate my-domain.com
```
This will give you a token which can be used for authentication and a secret which should be kept secure under all circumstances. 
The secret can then be used for validating the received update package via the HS256 algorithm.

## API
### Authorization
The api uses the bearer authorization header for identifying accessors. 
Accesses can be created via the `modernyze:generate` command. This will return a token for authentication and a secret for checking the file hash.
### Endpoints
The api persists of the following endpoints:

**Method:** `GET`  
**Description:** Get all available products.  
`/api/products/all`

**Method:** `GET`  
**Description:** Get all available versions for a product.  
`/api/product/{product}/versions`

**Method:** `GET`  
**Description:** Get the latest available version for a product.  
`/api/product/{product}/latest`

**Method:** `GET`  
**Description:** Get the download link and personal hash for a specific product version.  
`/api/product/{product}/{version}`

**Method:** `GET`  
**Description:** Download link for a specific product version (see above).  
`/api/product/{product}/{version}/download`



## License
The Modernyze project is open-sourced software licensed under the [MIT license](LICENSE).
