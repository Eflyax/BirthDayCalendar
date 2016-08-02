RED='\033[0;31m'
NC_RED='\033[0m' 

BLUE='\033[2;36m'
NC_BLUE='\033[0m' 

echo ""
echo "###########################################"
echo "#####_______${BLUE}NETTE${NC_BLUE}_cache_smazána_______#####"
echo "###########################################"
echo ""



BASEDIR=$(dirname "$0")
sudo chmod -R 777 "$BASEDIR/temp"
rm -R "$BASEDIR/temp/cache"
