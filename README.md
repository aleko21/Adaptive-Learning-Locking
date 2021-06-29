# Adaptive-Learning-Locking
A Moodle Plugin that adapts the learning path to student's prior knowledge using the Activity Locking feature.

With this plugin will be possible to hide (or make available) assets to students based on their level of preparation on certain topics.
This will allow users to focus their attention and energies only on the topics for which there are gaps by hiding assets containing notions previously acquired by the student.

The flow should work as follows: 

* The adiministrator set the course, the assets (resources) the tags and the questions;
* When enrolled in a new course, the student must answer a pre-test
* The adaptive system analyzes the results and builds the tailored learning path 
* The adaptive system shows only the learning object suitable to fill the knowledge gap identified by the test. Each learning object is linked to a learning goal, and a set of questions is linked to the learning goals.
* To complete the course, the user is forced attend to the available learning objects
* After the user studied all the available learning objects, the plugin will deliver another test (similar to the pretest).
* If the user passes this final test, the course will be considered completed, otherwise, the adaptive system will adapt the learning path again starting from the last test administered.

## DEVELOPMENT AND FUTURE WORKS
This plugin works on Moodle 2.x. The Research and Development team is searching partners in order to: 

1. Test the plugin and its functionality
2. Update the code and make it works with the current version of Moodle

Write an e-mail to alessandro.pagano@osel.it if you are interested in contributing
