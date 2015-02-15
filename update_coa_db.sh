wget "http://coa.inducks.org/inducks/isv.rar"
mkdir isv
unrar e isv.rar isv
mysql -p --local-infile<load_coa_data.sql
rm -R isv
rm isv.rar