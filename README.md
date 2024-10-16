
# Laravel Nginx MySQL Docker

This project is a boilerplate for setting up a Laravel application with Nginx and MySQL using Docker.

## Prerequisites

- Docker
- Docker Compose

## Project Structure

---

## Setup

1. **Clone the repository:**

    ```sh
    git clone https://github.com/yourusername/laravel-nginx-mysql-docker.git
    cd laravel-nginx-mysql-docker
    ```

2. **Copy the example environment file and update the environment variables:**

    ```sh
    cp app/.env.example app/.env
    ```

3. **Install the dependencies:**

    ```sh
    docker run --rm -v $(pwd)/app:/var/www -w /var/www composer install
    ```

4. **Build and start the Docker containers:**

    ```sh
    docker-compose up --build -d
    ```

5. **Run the database migrations:**

    ```sh
    docker-compose exec app-container php artisan migrate
    ```

## Usage

- Access the application at [http://localhost:8000](http://localhost:8000).
- To stop the containers, run:

    ```sh
    docker-compose down
    ```

## Additional Commands

- **Run Artisan commands:**

    ```sh
    docker-compose exec app-container php artisan <command>
    ```

- **Run Composer commands:**

    ```sh
    docker-compose exec app-container composer <command>
    ```

- **Run NPM commands:**

    ```sh
    docker-compose exec app-container npm <command>
    ```

## Contributing

Feel free to submit issues or pull requests.

## License

This project is licensed under the MIT License.