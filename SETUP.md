## Installation 

If your computer have Docker installed, go to step 1.3
## 1.1 Install Docker on Ubuntu

```
sudo apt-get install apt-transport-https ca-certificates curl -y
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
sudo apt-get update -y && sudo apt-get install -y docker-ce
sudo systemctl enable docker
sudo usermod -aG docker ${USER}
sudo reboot
  ```

## 1.2 Install Docker-compose

  - Install using python-pip: 

```
sudo apt-get -y install python-pip
sudo pip install docker-compose
```
    
  - **Test the installation**: `docker-compose --version`

## 1.3  Install project

- Clone project (Make sure it is develop environment)
```
git clone git@gitlab.com:ConnectivCorporation/contract/liris/LDM.git 
```

- Build docker-container service
```
cd LDM
docker-compose build
docker-compose up
```

- Modify the .env file to suit your need
```
- cp .env.example .env
```

- Edit `.env` file with following properties:  
``` 
DB_CONNECTION=mysql
DB_HOST=172.23.0.3
DB_PORT=3306
DB_DATABASE=liris
DB_USERNAME=docker
DB_PASSWORD=docker
```

- Add more necessary configs for AWS Cognito and AWS S3 to `.env`  

```
(Ask @Thai for the content.
It's not showen here for security reasons.) 
```


- Get into inside docker container, run command to build static files (css and js files)
```
docker exec -it liris-web bash
cd liris/
rm package-lock.json
npm install
npm run prod
```

- Still in docker container (Liris directory): Install composer and permission
```
composer install
chmod -Rf 777 storage/ bootstrap/
```

- When you have the .env with your database connection set up you can run your migrations and seeder
```
php artisan migrate:refresh --seed
```

HTTPS接続時の変更点
App\Http\Middleware\TrustProxies内の下記内容を変更すること
protected $proxies; ->  protected $proxies = '*';
