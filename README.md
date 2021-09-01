# Modernyze
Modernyze is a application that helps you build update servers for your application. 
It comes with a REST api for not only quering product versions, but also for downloading and verifying them.  
## Installation
### 1st Step
Clone or download the repo: 
```bash
git clone https://github.com/joonlabs/Modernyze.git
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

## License
The Modernyze project is open-sourced software licensed under the [MIT license](LICENSE).
