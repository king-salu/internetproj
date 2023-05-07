# Internet Projects Ltd / Q2 2023 / Interview Test Task

---

:scroll: **START**


Using the Symfony PHP Framework, the application carries out the requested task on [07-05-2023]
## Requirements
The requirements are as follows:
* Make a page (with pagination) displaying all teams and their players.
* Make a page where we can add a new team and its players.
* Make a page where we can sell/buy a player for a certain amount between two teams.

## Deployment
The project runs on the Symfony PHP framework with MySQL database
### Configuration
#### Database
Configure your database connection in the environment file at file path *-/.env*, adjust it to your localhost connection or deployable server connection.

> *ℹ️ please note that the entire database structure in MySQl has been extracted and can be found at file path **-/db_structure/internetprojects.sql**, you can run the 
queries in it to create the structure*

### Implemetation
Based on the requirements routes have been designed to carry out these requets, they are as follows:
* _Make a page (with pagination) displaying all teams and their players._  
[ **GET** ] **_{url}_**/  
> _with pagination:_ **_{url}_**/?page=**_{teamid}_**,**_{page_no}_**,**_{no_of_recs_per_page}_** 
Note that this is only explaining the route structure has it has already been implemented in the frontend development.

* _Make a page where we can add a new team_  
[ **GET** | **POST** ] **_{url}_**/team/

* _Make a page where we can add a new player_  
[ **GET** | **POST** ] **_{url}_**/players/

* _Make a page where we can sell/buy a player for a certain amount between two teams_  
[ **GET** ] **_{url}_**/trade/

---

:scroll: **END**
