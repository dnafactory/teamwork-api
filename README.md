# PHP integration with Teamwork API

[Click here to see API docs](https://developer.teamwork.com/)

#Integrated API

## TeamWork Projects

[Click here to see how retrieve API URL & Token](https://developer.teamwork.com/projects/apikey/key)

### Usage

`$caller = new \DNAFactory\Teamwork\Projects\APIPROXY($baseUrl, $token);`

`$caller->doSomethin();`

### List of APIPROXY

- Clock
- People
- Projects
- Tags
- TaskLists
- Tasks
- TimeTracking

### Concrete examples

see just 2 examples in samples/teamwork-projects

#### Clock

https://developer.teamwork.com/projects/api-v1/ref/clock-in-clock-out/

Available endpoints:

- getAllClocksIns()
- clockMeIn() <--- current user (by API token)
- clockMeOut() <--- current user (by API token)


#### People

https://developer.teamwork.com/projects/api-v1/ref/people/get-people-json

Available endpoints:

- getPeople()
- getPerson(personId)


#### Projects

https://developer.teamwork.com/projects/api-v1/ref/projects/get-projects-json

Available endpoints:

- getAllProjects()
- getSingleProject(projectId)


#### Tags

https://developer.teamwork.com/projects/api-v1/ref/tags/get-tags-json

Available endpoints:

- getAllTags()
- getSingleTag(tagId)


#### TaskLists

https://developer.teamwork.com/projects/task-lists/get-all-task-lists

Available endpoints:

- getAllTaskLists()
- getSingleTaskList(taskListId)
- getAllTaskListsByProject(projectId)


#### Tasks

https://developer.teamwork.com/projects/api-v1/ref/tasks/get-tasks-json

Available endpoints:

- getAllTasks()
- getSingleTask(taskId)
- getAllTasksByProject(projectId)
- getAllTasksByTaskList(taskListId)
- updateTask(taskId, array paramToUpdate)


#### TimeTracking

https://developer.teamwork.com/projects/api-v1/ref/time-tracking/get-time-entries-json

Available endpoints:

- getAllTimes()
- getSingleTime(timeId)
- getAllTimesByProject(projectId)
- getTotalTimeOnProject(projectId)
- getTotalTimeOnProjectByUser(projectId, userId)
- getTotalTimeOnTaskList(taskListId)
- getTotalTimeOnTaskListByUser(taskListId, userId)
- getTotalTimeOnTask(taskId)
- getTotalTimeOnTaskByUser(taskId, userId)


## TeamWork Desk

Not implemented yet

## TeamWork Chat

Not implemented yet

## TeamWork CRM

Not implemented yet

## TeamWork Spaces

Not implemented yet