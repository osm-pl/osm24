This is an osm24 project, which aims to show opening hours of different POIs using current OpenStreetMap data. It's written in PHP and JavaScript.

![screenshot](https://raw.githubusercontent.com/osm-pl/osm24/master/preview.png)

# Running

Simple docker-compose can be found in the repository. It can be used to run project locally at http://localhost:8080.

Start (`-d` runs it in detached mode):
```
docker-compose up -d
```
Stop:
```
docker-compose down
```

# Configuration

Configuration is stored inside `config.php` file. Please see this file for all the details.

All secret information (like passwords) should be kept inside `config.local.php` (example: `config.local.example.php`) which will never be stored inside VCS repository.
