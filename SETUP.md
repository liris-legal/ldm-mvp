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

- Clone project
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

- File .env development used docker
``` 
DB_CONNECTION=mysql
DB_HOST=172.23.0.3
DB_PORT=3306
DB_DATABASE=liris
DB_USERNAME=docker
DB_PASSWORD=docker
```

- If error: node_modules directory is missing. Please run npm install in your project directory
```
cd LDM
npm install
npm run prod
```

- Install composer and permission
```
docker exec -it liris-web bash
cd liris/
composer install
chmod -Rf 775 storage/ bootstrap/
```

- When you have the .env with your database connection set up you can run your migrations and seeder
```
php artisan migrate:refresh --seed
```
