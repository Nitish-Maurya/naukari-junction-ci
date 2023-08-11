git init
git add . 
git commit -am "first commit"


read -p "enter git url " url

git remote add origin $url

git push -f origin master

rm -rf .git
