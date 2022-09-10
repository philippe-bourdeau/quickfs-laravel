flush-images() {
    docker stop $(docker container ls -aq)
    docker rmi $(docker images -aq)
}
