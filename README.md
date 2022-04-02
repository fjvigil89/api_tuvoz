## About Api Installer

hacerle salva a la uri public/audio:

- git clone git@gitlab.com:frankjosue.vigilvega/voicerecord.git.
- composer install.
- cp .env.example .env
- php artisan key:generate.
- chmod -R 777 storage.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## DockerFile

`EXPOSE 8080`
# Set working directory
`WORKDIR /var/www/html/`
`COPY . .`
