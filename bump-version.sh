#!/bin/bash

set -e

if [ $# -ne 1 ]; then
  echo "Usage: `basename $0` <tag>"
  exit 65
fi

TAG=$1

#
# Tag & build master branch
#
git checkout master
git tag ${TAG}
box build

cp gizmo.phar gizmo-${TAG}.phar
git add gizmo-${TAG}.phar
git commit -m "Updated phar"

#
# Copy executable file into GH pages
#
git checkout -f gh-pages

git checkout master gizmo-${TAG}.phar

cp gizmo-${TAG}.phar downloads/gizmo-${TAG}.phar
git add downloads/gizmo-${TAG}.phar

SHA1=$(openssl sha1 gizmo-${TAG}.phar)

JSON='name:"gizmo.phar"'
JSON="${JSON},sha1:\"${SHA1}\""
JSON="${JSON},url:\"http://oluijks.github.io/gizmo/downloads/gizmo-${TAG}.phar\""
JSON="${JSON},version:\"${TAG}\""

#
# Update manifest
#
cat downloads/manifest.json | /usr/local/bin/jsawk -a "this.push({${JSON}})" | python -mjson.tool > manifest.json.tmp
mv manifest.json.tmp downloads/manifest.json
git add downloads/manifest.json
git add downloads/gizmo-${TAG}.phar

git commit -m "Bump version ${TAG}"

#
# Go back to master
#
git checkout master

echo "New version created. Now you should run:"
echo "git push origin gh-pages"
echo "git push ${TAG}"
