# Task List API

This projects serves as the API endpoint for a task list project. The project serves as a task management application.
The base url link for the project is [BaseUrl](https://pwg-task-list-api.herokuapp.com/api/). The App features two tables,

- `Tasks` table which holds tasks data.
- `Settings` table which determines somen behaviours in the application. Like the `allow_duplicates` settings determines whether a task can have duplicate labels, presently this setting is set to `false` which means the application won't allow duplicate labels. 

## Features

- Get a list of Task which can be based on `allow_duplicates` setting.
- Create a task
- update a task label based on `allow_duplicates` setting.
- update task sort order
- update task completed time

## API Endpoint Documentation

### `/tasks/get-tasks`: Used to get a list of all tasks from the database
   - Method: `GET`
   - Body Params: none.
   - Query Params: none.
   - Response:
        - Success: 
            ```bash
                {
                "tasks": [
                    {
                        "id": 1,
                        "label": "Clean",
                        "sort_order": 1,
                        "completed_at": "2022-02-11 06:44:00",
                        "created_at": null,
                        "updated_at": null
                    },
                    {
                        "id": 2,
                        "label": "Wash do",
                        "sort_order": 2,
                        "completed_at": "2022-02-11 06:44:00",
                        "created_at": null,
                        "updated_at": null
                    },
                    {
                        "id": 3,
                        "label": "Rub",
                        "sort_order": 3,
                        "completed_at": "2022-02-11 06:44:00",
                        "created_at": null,
                        "updated_at": null
                    }
                ]
            }
            ```
   
###  `/tasks/add-task`: Add a task into the database.
   - Method: `POST`
   - Body Params: Only the the `label` parameter is needed in the request to create a task
        - `label`: Specifies a brief description of the task, cannot have duplicates if `allow_duplicates` setting is `false`.
            - Attributes: `Required`, `String`, and must not be more than `191` characters.
        - Response:
        - On Success: status => `201`,
            Response body
            ```bash
            {
               "message": "Task Added Successfully",
                "task": {
                    "label": "new label 1",
                    "sort_order": 5,
                    "completed_at": "2022-02-11 06:20:48",
                    "updated_at": "2022-02-11 06:20:48",
                    "created_at": "2022-02-11 06:20:48",
                    "id": 5
                }
            }
            ```
        - On Failure due to duplictate: status `400`, 
            Response Body
            ```bash
                {
                    "message": "duplicate task cannot be added due to allow_duplicates settings"
                }
            ```


###  `/tasks/update-task/{id}`: Add a task into the database.
   - Method: `PUT`
   - Query Params:
        - id: Id of the task to be updated.
   - Body Params:
        - `label`- Specifies a brief description of the task, cannot have duplicates if `allow_duplicates` setting is `false`.
            - Attributes: `Nullable`, `String`, and must not be more than `191` characters.

        - `sort_order` - Specifies the index/postion at which the task should be sorted.
            - Attributes: `Nullable`, and must be an`Integer`.

        - `task_completed_status` - Specifies how a task is being completed, if true then it sets the `completed_at` metadata to current time which specifies the task has been completed. if `false` it sets the `completed_at` metadata to the same time at which the task was created which simplifies that the task have not been completed.
            - Attributes: `Nullable`, and must be an`boolean`.

        - Response:
        - On Success: status => `200`,
            Response body
            ```bash
            {
                "message": "Task Updated Successfully",
                "task": {
                    "id": 4,
                    "label": "new label",
                    "sort_order": 2,
                    "completed_at": "2022-02-11 05:38:47",
                    "created_at": "2022-02-11 05:32:09",
                    "updated_at": "2022-02-11 05:38:47"
            }
            ```
        - On Failure due to duplictate: status `400`, 
            Response Body
            ```bash
                {
                    "message": "duplicate task cannot be added due to allow_duplicates settings"
                }
            ```
        - can also throw validation errors `422` error based on the attributes of the parameters.


## Setup the project locally (Running locally)

-   Clone the project

```bash
git clone https://github.com/adejam/task-list-api.git

```

-   Install Dependencies

```bash
composer install
```

- Setup Database and migrate tables with seeders

```bash
php artisan migrate:fresh --seed
```

- To Run tests
```bash
vendor/bin/phpunit
```

To check for errors on PHP

```bash
composer phpcs
```

Or to beautify PHP codes and fix phpcs errors

```bash
composer phpcbf
```
