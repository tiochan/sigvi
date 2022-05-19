#!/bin/sh

DOCKER_NAME=$(basename $PWD)

echo "Building container $DOCKER_NAME"

docker build -t $DOCKER_NAME .

if [ ! $? -eq 0 ]; then
	echo "Error building container"
	exit 1
fi

echo "To run it execute:"
echo "docker run -v /tmp/${TMP}:/tmp -it --rm --name running-${DOCKER_NAME} ${DOCKER_NAME}"


