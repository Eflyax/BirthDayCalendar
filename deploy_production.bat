@ECHO OFF
SET /P uname=You are about to deploy to the production server, write 'yes' to continue:
IF "%uname%"=="yes" GOTO Start
ECHO Deploy stopped
GOTO End
:Start
php Deployment/Deployment/deployment.php app/config/deploy/deployment_production.ini
:End

