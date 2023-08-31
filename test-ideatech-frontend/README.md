# FrontEnd for test Ideatch
This project needs the backend to be running, to install and run the backend follow the project instructions

<br>

### Dependencies:
To run the project you need to have Docker and Docker Compose installed.  
It is also necessary to have the make command already installed.

<br />

After create a file .env and put that content
<details>
<summary>.env</summary>

```.dotenv
VITE_API_BASE=http://localhost:8080/v1
```
</details>

### Installing and running

First check if the Docker service is already running, with the Docker service running, enter the
project and run the command:
```bash
make d-up
```
with this command we will download and build the Docker image.   
After finishing the process, After that we have the frontend running and we can access in:
```
http://localhost:3000/
```
