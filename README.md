# TPXimpact Backend Challenge
## Summary
This project is my take at the [TPXimpact Backend Challenge](https://dx-tech-challenge.tpximpact.com/part-2/option-2-backend-challenge).

It uses [Symfony Console](https://symfony.com/doc/current/console.html) with the [Question Helper](https://symfony.com/doc/current/components/console/helpers/questionhelper.html) to manage input/output in the terminal.

## Structure
The project add one main Command to the Symfony Console application called `BackendChallengeCommand`, and runs everything in its `execute()` method

Before `BackendChallengeCommand::execute()` is executed, the program runs `BackendChallengeCommand::initialize()`, and this does 3 things:

 - ask the user if they want to load a previously saved game if a save file is found
 - initialise the player's character from data found in the save file, or from default values if no save file is loaded
 - prepare the "map", which is a list of rooms in which the character will go through during the game

### Character
The character is a singleton object implementing `CharacterInterface` that holds various data such as the number of health points (hearts) available, a name and a number indicating the progress the character has made through the map.

This is the main object of the game, and its data will change throughout the game, this is also this data that will be saved to and loaded from save files.

### Rooms
The rooms are parsed and loaded from a static YAML file with the [Symfony YAML](https://symfony.com/doc/current/components/yaml.html) component.

Each room is an object implementing `RoomInterface` that contains three informations:

 - a flavour text (introduction) that will be presented to the player upon entering the room
 - a question that the player will have to answer in order to pass through
 - a list of possible answers the player can choose from

The list of possible answers is an array of objects implementing `OutcomeInterface` and each outcome contains consequences that are object implementing `EventInterface`

### Events
When the player chooses an outcome for a question, all the consequence events held by the outcome will be executed through the `EventInterface::resolveEvent()` method.

Most events will update the data held in the character to make it evolve, and some will also throw exceptions that extend `BackendChallengeException`

These exceptions will then be caught by the main loop in `BackendChallengeCommand::execute()` and will terminate the game, and return a specific return code, according to the type of the exception (win, lose, death of character, etc.)
