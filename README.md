1. Run: docker compose up
2. Open http://localhost:8000/wp-admin/
3. Go to Plugins > Installed plugins
                If plugins installed(Elementor, Gutenify, LiteSpeed Cache, Translatepress, UpdraftPlus) > 
                Activate them, if not activated.
                If plugins not installed, install these plugins:
                Elementor, Gutenify, LiteSpeed Cache, Translatepress, UpdraftPlus
4. How to use of UpdraftPlus => 1. After installing and activating all plugins > go to Plugins > Installed plugins > UpdraftPlus > Settings > Existing backups > Upload backup files > Select files > Open project directory > database > backup_2023.zip (ZIP-file)
When you change something on website, need to take a backup file (database):
Go to Plugins > Installed plugins > UpdraftPlus > Settings > Next scheduled backups > Backup now > Next
After backup competed > go down > Choose current database file with date > click Database button > click Download to your computer > open directory where database downloaded > choose database file (zip for Windows, dz for Mac) > delete previos database files from database directory > move a new database file in database directory.
5. For editing homepage of website > Visit website > Edit website button
6. For editing/adding other pages > Dashboard > Pages > All pages > Edit with Elementor/Add new
7. For change translation/language on website Go to Plugins > Installed plugins > Translatepress > Settings > Translate site > Find a paragraph/string where we need changes > click "blue pensil button" > Choose from which language to another language and paste translation > click Save translation.
8. Commit and push code in VSCode.
