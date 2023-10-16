First pull project https://github.com/Tapan1996/reactcrud.git and run

```composer install```

copy env

```cp .env.example .env```

run sail 

```./vendor/bin/sail up```

or after alias ```alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'``` in ~/.zshrc file you can run 

```sail up```

the docker may need permission, so just exec it and chown it or you can just chmod
``` docker exec -it {docker_id} bash```
```cd ..```
``` chown -R sail:sail html```

generate app key

```sail artisan key:generate```

migrate

```sail artisan migrate```


aplicaton runs on port 8000 (port can be changed in docker-compose.yml)

