<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class McqSeeder extends Seeder
{
    public function run(): void
    {
        $data = $this->data();

        foreach ($data as $catData) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($catData['name'])],
                [
                    'name'        => $catData['name'],
                    'description' => $catData['description'],
                    'type'        => 'test',
                ]
            );

            foreach ($catData['tests'] as $testData) {
                $slug = Str::slug($testData['title']);
                if (Test::where('slug', $slug)->exists()) {
                    $slug .= '-' . Str::random(4);
                }

                $test = Test::create([
                    'category_id'           => $category->id,
                    'title'                 => $testData['title'],
                    'slug'                  => $slug,
                    'description'           => $testData['description'],
                    'total_time'            => $testData['time'],
                    'passing_marks'         => $testData['passing'],
                    'difficulty'            => $testData['difficulty'],
                    'has_certificate'       => true,
                    'certificate_min_score' => 70,
                    'status'                => 'published',
                    'hashtags'              => $testData['tags'],
                ]);

                $order = 0;
                foreach ($testData['questions'] as $qData) {
                    $order++;
                    $question = Question::create([
                        'test_id'        => $test->id,
                        'question'       => $qData['q'],
                        'explanation'    => $qData['exp'] ?? null,
                        'marks'          => 1,
                        'question_order' => $order,
                    ]);

                    foreach ($qData['opts'] as $i => $opt) {
                        $question->options()->create([
                            'option_text' => $opt,
                            'is_correct'  => ($i === $qData['correct']) ? 1 : 0,
                        ]);
                    }
                }

                $test->update([
                    'total_questions' => $test->questions()->count(),
                    'total_marks'     => $test->questions()->sum('marks'),
                ]);
            }
        }

        $this->command->info('MCQ Seeder completed: 5 categories, 10 tests, questions loaded.');
    }

    private function data(): array
    {
        return [
            /* ═══════════════════════ PHP ═══════════════════════ */
            [
                'name'        => 'PHP',
                'description' => 'Test your PHP programming skills from basics to advanced.',
                'tests'       => [
                    [
                        'title'       => 'PHP Fundamentals',
                        'description' => 'Core PHP syntax, variables, loops and functions.',
                        'time'        => 20, 'passing' => 6, 'difficulty' => 'beginner',
                        'tags'        => 'php,basics,variables,functions',
                        'questions'   => [
                            ['q' => 'What does PHP stand for?', 'opts' => ['PHP: Hypertext Preprocessor', 'Private Home Page', 'Preprocessor Home PHP', 'Personal Hypertext Processor'], 'correct' => 0, 'exp' => 'PHP originally stood for Personal Home Page but now recursively stands for PHP: Hypertext Preprocessor.'],
                            ['q' => 'Which symbol is used to declare a variable in PHP?', 'opts' => ['@', '#', '$', '&'], 'correct' => 2, 'exp' => 'In PHP, variables are prefixed with a $ sign, e.g., $name = "John".'],
                            ['q' => 'Which function is used to output text in PHP?', 'opts' => ['print_r()', 'console.log()', 'echo', 'printf()'], 'correct' => 2, 'exp' => 'echo is the most commonly used language construct to output text in PHP.'],
                            ['q' => 'What is the correct way to end a PHP statement?', 'opts' => ['Period (.)', 'Comma (,)', 'Colon (:)', 'Semicolon (;)'], 'correct' => 3, 'exp' => 'PHP statements must end with a semicolon (;).'],
                            ['q' => 'Which PHP function is used to get the length of a string?', 'opts' => ['len()', 'count()', 'strlen()', 'size()'], 'correct' => 2, 'exp' => 'strlen() returns the number of characters in a string.'],
                            ['q' => 'What will "echo 10 % 3;" output?', 'opts' => ['3', '1', '0', '3.33'], 'correct' => 1, 'exp' => '10 divided by 3 is 3 remainder 1, so 10 % 3 = 1.'],
                            ['q' => 'Which of these is NOT a valid PHP data type?', 'opts' => ['Integer', 'Float', 'Character', 'Boolean'], 'correct' => 2, 'exp' => 'PHP does not have a standalone "character" type. Single characters are treated as strings.'],
                            ['q' => 'How do you write a single-line comment in PHP?', 'opts' => ['/* comment */', '<!-- comment -->', '// comment', '# comment only'], 'correct' => 2, 'exp' => 'Both // and # can be used for single-line comments in PHP.'],
                            ['q' => 'Which loop runs the body at least once even if the condition is false?', 'opts' => ['for', 'while', 'foreach', 'do-while'], 'correct' => 3, 'exp' => 'The do-while loop checks the condition after executing the body, so it always runs at least once.'],
                            ['q' => 'Which superglobal holds form data sent via POST?', 'opts' => ['$_GET', '$_REQUEST', '$_POST', '$_FORM'], 'correct' => 2, 'exp' => '$_POST is the superglobal array that holds data submitted via HTTP POST method.'],
                        ],
                    ],
                    [
                        'title'       => 'PHP OOP Concepts',
                        'description' => 'Object-oriented programming in PHP — classes, inheritance, interfaces.',
                        'time'        => 25, 'passing' => 7, 'difficulty' => 'intermediate',
                        'tags'        => 'php,oop,classes,inheritance',
                        'questions'   => [
                            ['q' => 'Which keyword is used to create a class in PHP?', 'opts' => ['object', 'class', 'new', 'define'], 'correct' => 1, 'exp' => 'The class keyword is used to define a class in PHP.'],
                            ['q' => 'Which method is automatically called when an object is created?', 'opts' => ['init()', 'create()', '__construct()', 'start()'], 'correct' => 2, 'exp' => '__construct() is the constructor method, called automatically when you instantiate a class.'],
                            ['q' => 'What keyword is used to inherit from another class?', 'opts' => ['implements', 'inherits', 'extends', 'uses'], 'correct' => 2, 'exp' => 'The extends keyword enables a class to inherit properties and methods from a parent class.'],
                            ['q' => 'Which visibility modifier makes a property accessible only within its class?', 'opts' => ['public', 'protected', 'private', 'internal'], 'correct' => 2, 'exp' => 'private restricts access to the defining class only.'],
                            ['q' => 'What is an interface in PHP?', 'opts' => ['A complete class', 'A contract defining methods a class must implement', 'A global variable', 'An abstract property'], 'correct' => 1, 'exp' => 'An interface defines a contract — a set of method signatures that implementing classes must define.'],
                            ['q' => 'Which keyword is used to implement an interface?', 'opts' => ['extends', 'inherits', 'uses', 'implements'], 'correct' => 3, 'exp' => 'A class uses implements to fulfill an interface contract.'],
                            ['q' => 'Can a PHP class implement multiple interfaces?', 'opts' => ['No', 'Yes', 'Only 2 max', 'Only with abstract classes'], 'correct' => 1, 'exp' => 'PHP classes can implement multiple interfaces separated by commas.'],
                            ['q' => 'Which keyword is used to call the parent class constructor?', 'opts' => ['parent::__construct()', 'super()', 'base()', 'this::parent()'], 'correct' => 0, 'exp' => 'parent::__construct() explicitly calls the parent class constructor in PHP.'],
                            ['q' => 'A class that cannot be instantiated directly is called?', 'opts' => ['Final class', 'Static class', 'Abstract class', 'Interface'], 'correct' => 2, 'exp' => 'Abstract classes are declared with the abstract keyword and cannot be instantiated.'],
                            ['q' => 'What does the static keyword do on a class property?', 'opts' => ['Makes it constant', 'Makes it accessible without instantiation', 'Makes it private', 'Makes it read-only'], 'correct' => 1, 'exp' => 'Static properties and methods belong to the class itself and can be accessed without creating an object.'],
                        ],
                    ],
                ],
            ],

            /* ═══════════════════════ JavaScript ═══════════════════════ */
            [
                'name'        => 'JavaScript',
                'description' => 'JavaScript from DOM manipulation to ES6+ modern features.',
                'tests'       => [
                    [
                        'title'       => 'JavaScript Basics',
                        'description' => 'Variables, data types, operators and control flow in JavaScript.',
                        'time'        => 20, 'passing' => 6, 'difficulty' => 'beginner',
                        'tags'        => 'javascript,basics,variables',
                        'questions'   => [
                            ['q' => 'Which keyword declares a block-scoped variable in modern JavaScript?', 'opts' => ['var', 'let', 'define', 'set'], 'correct' => 1, 'exp' => 'let declares a block-scoped variable, introduced in ES6.'],
                            ['q' => 'What is the output of: typeof null?', 'opts' => ['"null"', '"undefined"', '"object"', '"boolean"'], 'correct' => 2, 'exp' => 'typeof null returns "object" — a known JavaScript quirk/bug that has never been fixed for compatibility reasons.'],
                            ['q' => 'Which operator checks both value and type equality?', 'opts' => ['==', '!=', '===', '=>'], 'correct' => 2, 'exp' => '=== is the strict equality operator, checking both value and type.'],
                            ['q' => 'How do you declare a constant in JavaScript?', 'opts' => ['let', 'var', 'const', 'fixed'], 'correct' => 2, 'exp' => 'const declares a block-scoped constant that cannot be reassigned.'],
                            ['q' => 'What does NaN stand for?', 'opts' => ['Not any Number', 'Not a Number', 'Null and None', 'Negative and Natural'], 'correct' => 1, 'exp' => 'NaN stands for "Not a Number" and represents an undefined or unrepresentable numeric result.'],
                            ['q' => 'Which method converts a JSON string to a JavaScript object?', 'opts' => ['JSON.stringify()', 'JSON.parse()', 'JSON.convert()', 'JSON.decode()'], 'correct' => 1, 'exp' => 'JSON.parse() parses a JSON string and returns the corresponding JavaScript value.'],
                            ['q' => 'How do you write an arrow function that returns x * 2?', 'opts' => ['function(x) { return x * 2; }', 'x => x * 2', 'x -> x * 2', '(x) ** 2'], 'correct' => 1, 'exp' => 'Arrow functions use => syntax: x => x * 2 is a concise arrow function.'],
                            ['q' => 'Which array method creates a new array with transformed elements?', 'opts' => ['filter()', 'forEach()', 'map()', 'reduce()'], 'correct' => 2, 'exp' => 'Array.map() creates a new array populated with results of calling a function on every element.'],
                            ['q' => 'What is the result of 0 == false in JavaScript?', 'opts' => ['false', 'true', 'undefined', 'TypeError'], 'correct' => 1, 'exp' => 'With loose equality (==), 0 and false are considered equal because of type coercion.'],
                            ['q' => 'Which event fires when the DOM is fully loaded?', 'opts' => ['window.onload', 'DOMContentLoaded', 'document.ready', 'page.load'], 'correct' => 1, 'exp' => 'DOMContentLoaded fires when the HTML has been fully parsed, without waiting for stylesheets or images.'],
                        ],
                    ],
                    [
                        'title'       => 'ES6+ & Modern JavaScript',
                        'description' => 'Promises, async/await, destructuring, modules and more.',
                        'time'        => 30, 'passing' => 7, 'difficulty' => 'intermediate',
                        'tags'        => 'javascript,es6,async,promises',
                        'questions'   => [
                            ['q' => 'What does the spread operator (...) do?', 'opts' => ['Deletes array items', 'Expands an iterable into individual elements', 'Merges two functions', 'Declares rest parameters only'], 'correct' => 1, 'exp' => 'The spread operator expands an array or object into individual elements.'],
                            ['q' => 'What is a Promise in JavaScript?', 'opts' => ['A synchronous callback', 'An object representing an eventual async result', 'A new data type', 'A class decorator'], 'correct' => 1, 'exp' => 'A Promise represents the eventual completion or failure of an asynchronous operation.'],
                            ['q' => 'Which keyword pauses async function execution until a Promise resolves?', 'opts' => ['pause', 'wait', 'await', 'hold'], 'correct' => 2, 'exp' => 'await pauses execution of an async function until the Promise resolves or rejects.'],
                            ['q' => 'What does destructuring assignment do?', 'opts' => ['Deletes object properties', 'Unpacks values from arrays/objects into variables', 'Creates new objects', 'Copies objects by value'], 'correct' => 1, 'exp' => 'Destructuring lets you unpack values from arrays or properties from objects into distinct variables.'],
                            ['q' => 'Which method returns a new array with elements that pass a test?', 'opts' => ['map()', 'find()', 'filter()', 'some()'], 'correct' => 2, 'exp' => 'Array.filter() creates a new array with all elements that pass the provided test function.'],
                            ['q' => 'What is a template literal?', 'opts' => ['A CSS template', 'A string enclosed in backticks supporting interpolation', 'A JavaScript class template', 'An HTML template tag'], 'correct' => 1, 'exp' => 'Template literals use backticks (`) and allow embedded expressions with ${}.'],
                            ['q' => 'What does Object.keys() return?', 'opts' => ['Array of values', 'Array of key-value pairs', 'Array of property names', 'Length of object'], 'correct' => 2, 'exp' => 'Object.keys() returns an array of the object\'s own enumerable property names.'],
                            ['q' => 'What is the purpose of async/await over Promises?', 'opts' => ['It is faster', 'It makes async code read synchronously', 'It avoids all errors', 'It creates threads'], 'correct' => 1, 'exp' => 'async/await is syntactic sugar over Promises that makes async code easier to read and write.'],
                            ['q' => 'What does the nullish coalescing operator (??) return?', 'opts' => ['Left operand if truthy', 'Right operand if left is null or undefined', 'Boolean true/false', 'Left operand always'], 'correct' => 1, 'exp' => '?? returns the right-hand side when the left is null or undefined, unlike || which triggers on any falsy value.'],
                            ['q' => 'What is a closure?', 'opts' => ['A finished function', 'A function that remembers its outer scope variables', 'A sealed object', 'A private class'], 'correct' => 1, 'exp' => 'A closure is a function that retains access to its outer scope even after the outer function has returned.'],
                        ],
                    ],
                ],
            ],

            /* ═══════════════════════ Python ═══════════════════════ */
            [
                'name'        => 'Python',
                'description' => 'Python programming language — syntax, data structures and OOP.',
                'tests'       => [
                    [
                        'title'       => 'Python Basics',
                        'description' => 'Python syntax, built-in types, loops and functions.',
                        'time'        => 20, 'passing' => 6, 'difficulty' => 'beginner',
                        'tags'        => 'python,basics,syntax',
                        'questions'   => [
                            ['q' => 'Which keyword defines a function in Python?', 'opts' => ['func', 'function', 'def', 'define'], 'correct' => 2, 'exp' => 'The def keyword is used to define a function in Python.'],
                            ['q' => 'What is the output of print(type([]))?', 'opts' => ["<class 'tuple'>", "<class 'list'>", "<class 'array'>", "<class 'dict'>"], 'correct' => 1, 'exp' => '[] creates an empty list, so type([]) returns <class \'list\'>.'],
                            ['q' => 'Which of these creates an immutable sequence in Python?', 'opts' => ['list', 'dict', 'set', 'tuple'], 'correct' => 3, 'exp' => 'Tuples are immutable sequences, unlike lists which are mutable.'],
                            ['q' => 'How do you add an element to a Python list?', 'opts' => ['list.add()', 'list.push()', 'list.append()', 'list.insert_end()'], 'correct' => 2, 'exp' => 'list.append(item) adds an element to the end of a list.'],
                            ['q' => 'What does len("hello") return?', 'opts' => ['4', '5', '6', 'Error'], 'correct' => 1, 'exp' => 'len() returns the number of characters. "hello" has 5 characters.'],
                            ['q' => 'Which statement is used to handle exceptions in Python?', 'opts' => ['catch-throw', 'try-except', 'try-catch', 'handle-error'], 'correct' => 1, 'exp' => 'Python uses try-except blocks for exception handling.'],
                            ['q' => 'What is the correct way to create a dictionary in Python?', 'opts' => ['d = []', 'd = ()', 'd = {}', 'd = <>'], 'correct' => 2, 'exp' => 'Dictionaries are created with curly braces {} containing key: value pairs.'],
                            ['q' => 'Which loop is used to iterate over a sequence in Python?', 'opts' => ['while', 'for-in', 'do-while', 'repeat'], 'correct' => 1, 'exp' => 'The for-in loop iterates over any iterable (lists, strings, tuples, etc.).'],
                            ['q' => 'What does the range(5) function produce?', 'opts' => ['[1,2,3,4,5]', '[0,1,2,3,4]', '[0,1,2,3,4,5]', '[1,2,3,4]'], 'correct' => 1, 'exp' => 'range(5) generates numbers from 0 up to (but not including) 5: 0, 1, 2, 3, 4.'],
                            ['q' => 'What is the output of: 3 ** 2 in Python?', 'opts' => ['6', '5', '9', '8'], 'correct' => 2, 'exp' => '** is the exponentiation operator. 3 ** 2 = 3 squared = 9.'],
                        ],
                    ],
                ],
            ],

            /* ═══════════════════════ Database ═══════════════════════ */
            [
                'name'        => 'Database & SQL',
                'description' => 'SQL queries, database design, normalization and optimization.',
                'tests'       => [
                    [
                        'title'       => 'SQL Fundamentals',
                        'description' => 'Master SELECT, JOIN, GROUP BY and essential SQL clauses.',
                        'time'        => 25, 'passing' => 7, 'difficulty' => 'beginner',
                        'tags'        => 'sql,database,mysql,queries',
                        'questions'   => [
                            ['q' => 'Which SQL statement is used to retrieve data from a database?', 'opts' => ['GET', 'FETCH', 'SELECT', 'RETRIEVE'], 'correct' => 2, 'exp' => 'SELECT is the fundamental SQL command for querying data from tables.'],
                            ['q' => 'Which clause filters rows in a SELECT query?', 'opts' => ['HAVING', 'WHERE', 'FILTER', 'LIMIT'], 'correct' => 1, 'exp' => 'WHERE filters rows before aggregation; HAVING filters after.'],
                            ['q' => 'What does SELECT DISTINCT do?', 'opts' => ['Selects the first row', 'Returns only unique values', 'Orders results', 'Counts rows'], 'correct' => 1, 'exp' => 'DISTINCT eliminates duplicate rows from the result set.'],
                            ['q' => 'Which JOIN returns only matching rows from both tables?', 'opts' => ['LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN', 'INNER JOIN'], 'correct' => 3, 'exp' => 'INNER JOIN returns rows where there is a match in both tables.'],
                            ['q' => 'What does GROUP BY do in SQL?', 'opts' => ['Sorts results', 'Groups rows sharing a value for use with aggregate functions', 'Joins tables', 'Filters rows'], 'correct' => 1, 'exp' => 'GROUP BY groups rows with the same values into summary rows for use with COUNT, SUM, AVG, etc.'],
                            ['q' => 'Which aggregate function returns the number of rows?', 'opts' => ['SUM()', 'AVG()', 'COUNT()', 'TOTAL()'], 'correct' => 2, 'exp' => 'COUNT() returns the number of rows that match a specified condition.'],
                            ['q' => 'Which SQL command adds new records to a table?', 'opts' => ['ADD', 'INSERT INTO', 'UPDATE', 'CREATE'], 'correct' => 1, 'exp' => 'INSERT INTO table (cols) VALUES (vals) is the syntax for inserting new rows.'],
                            ['q' => 'What does a PRIMARY KEY constraint ensure?', 'opts' => ['All values are positive', 'Unique and non-null identification for each row', 'Values match a foreign table', 'Values are indexed'], 'correct' => 1, 'exp' => 'A PRIMARY KEY uniquely identifies each row and cannot be NULL.'],
                            ['q' => 'Which SQL keyword sorts results in descending order?', 'opts' => ['ORDER ASC', 'ORDER BY DESC', 'SORT DOWN', 'REVERSE BY'], 'correct' => 1, 'exp' => 'ORDER BY column DESC sorts results from highest to lowest.'],
                            ['q' => 'What is a FOREIGN KEY?', 'opts' => ['A key that is encrypted', 'A field that links to the PRIMARY KEY of another table', 'A backup primary key', 'An auto-incremented field'], 'correct' => 1, 'exp' => 'A FOREIGN KEY creates a referential link between tables, enforcing relational integrity.'],
                        ],
                    ],
                    [
                        'title'       => 'Database Design & Normalization',
                        'description' => 'Normal forms, relationships, indexing and database best practices.',
                        'time'        => 30, 'passing' => 7, 'difficulty' => 'intermediate',
                        'tags'        => 'database,normalization,design,schema',
                        'questions'   => [
                            ['q' => 'What is 1NF (First Normal Form)?', 'opts' => ['Tables must have a primary key only', 'Eliminate repeating groups; each column must have atomic values', 'All columns must depend on primary key', 'Eliminate transitive dependencies'], 'correct' => 1, 'exp' => '1NF requires that each table cell contains a single (atomic) value and each record is unique.'],
                            ['q' => 'Which normal form eliminates partial dependencies?', 'opts' => ['1NF', '2NF', '3NF', 'BCNF'], 'correct' => 1, 'exp' => '2NF builds on 1NF by removing partial dependencies — non-key columns must depend on the WHOLE primary key.'],
                            ['q' => 'What is a transitive dependency?', 'opts' => ['A column depends on a foreign key', 'A non-key column depends on another non-key column', 'A table with no primary key', 'A recursive relationship'], 'correct' => 1, 'exp' => 'A transitive dependency occurs when a non-key attribute depends on another non-key attribute. 3NF removes these.'],
                            ['q' => 'What is the purpose of database indexing?', 'opts' => ['To encrypt data', 'To speed up data retrieval operations', 'To normalize tables', 'To enforce foreign keys'], 'correct' => 1, 'exp' => 'Indexes allow the database engine to find rows faster without scanning the entire table.'],
                            ['q' => 'What type of relationship uses a junction (bridge) table?', 'opts' => ['One-to-one', 'One-to-many', 'Many-to-many', 'Self-referencing'], 'correct' => 2, 'exp' => 'Many-to-many relationships require a junction table to hold the pairs of foreign keys.'],
                            ['q' => 'What does ACID stand for in database transactions?', 'opts' => ['Array, Class, Index, Data', 'Atomicity, Consistency, Isolation, Durability', 'Access, Control, Integrity, Data', 'Aggregate, Cluster, Index, Delete'], 'correct' => 1, 'exp' => 'ACID properties guarantee reliable database transactions: Atomicity, Consistency, Isolation, Durability.'],
                            ['q' => 'Which SQL statement is used to remove an entire table?', 'opts' => ['DELETE TABLE', 'REMOVE TABLE', 'DROP TABLE', 'ERASE TABLE'], 'correct' => 2, 'exp' => 'DROP TABLE removes the table and all its data permanently from the database.'],
                            ['q' => 'What is a view in a database?', 'opts' => ['A physical copy of a table', 'A virtual table based on a SELECT query', 'An indexed table', 'A temporary table'], 'correct' => 1, 'exp' => 'A view is a saved SQL query that behaves like a virtual table.'],
                            ['q' => 'What does the TRUNCATE command do?', 'opts' => ['Deletes one row', 'Removes all rows but keeps the table structure', 'Drops the table', 'Rolls back changes'], 'correct' => 1, 'exp' => 'TRUNCATE removes all rows from a table quickly without logging individual row deletions.'],
                            ['q' => 'Which type of index is automatically created for a PRIMARY KEY?', 'opts' => ['Composite index', 'Unique index', 'Clustered index', 'Full-text index'], 'correct' => 2, 'exp' => 'Most databases automatically create a clustered index on the primary key column(s).'],
                        ],
                    ],
                ],
            ],

            /* ═══════════════════════ Git & Linux ═══════════════════════ */
            [
                'name'        => 'Git & Linux',
                'description' => 'Version control with Git and essential Linux/terminal commands.',
                'tests'       => [
                    [
                        'title'       => 'Git Version Control',
                        'description' => 'Git commands, branching, merging and collaboration workflows.',
                        'time'        => 20, 'passing' => 6, 'difficulty' => 'beginner',
                        'tags'        => 'git,github,version-control,branches',
                        'questions'   => [
                            ['q' => 'Which command initializes a new Git repository?', 'opts' => ['git start', 'git new', 'git init', 'git create'], 'correct' => 2, 'exp' => 'git init creates a new empty Git repository or reinitializes an existing one.'],
                            ['q' => 'Which command stages all changed files for commit?', 'opts' => ['git commit -a', 'git add .', 'git stage all', 'git push'], 'correct' => 1, 'exp' => 'git add . stages all modified and new files in the current directory.'],
                            ['q' => 'Which command creates and switches to a new branch?', 'opts' => ['git branch new-branch', 'git switch new-branch', 'git checkout -b new-branch', 'git new-branch'], 'correct' => 2, 'exp' => 'git checkout -b creates a new branch and immediately switches to it. The modern way is git switch -c.'],
                            ['q' => 'What does git pull do?', 'opts' => ['Pushes local commits to remote', 'Fetches and merges changes from remote', 'Creates a new branch', 'Stashes local changes'], 'correct' => 1, 'exp' => 'git pull = git fetch + git merge: it downloads changes from the remote and merges them.'],
                            ['q' => 'Which command undoes the last commit but keeps changes staged?', 'opts' => ['git revert HEAD', 'git reset HEAD~1 --soft', 'git undo', 'git rollback'], 'correct' => 1, 'exp' => 'git reset HEAD~1 --soft moves HEAD back one commit but keeps all changes staged.'],
                            ['q' => 'What is a merge conflict?', 'opts' => ['When push fails', 'When two branches have conflicting changes in the same file', 'When the remote is ahead', 'When a commit message is missing'], 'correct' => 1, 'exp' => 'A merge conflict occurs when two branches modify the same part of a file differently.'],
                            ['q' => 'Which command shows the commit history?', 'opts' => ['git status', 'git history', 'git log', 'git show'], 'correct' => 2, 'exp' => 'git log displays the commit history with hashes, authors, dates and messages.'],
                            ['q' => 'What does .gitignore do?', 'opts' => ['Deletes ignored files', 'Specifies files Git should not track', 'Marks files as read-only', 'Encrypts sensitive files'], 'correct' => 1, 'exp' => '.gitignore tells Git which files and folders to exclude from tracking.'],
                            ['q' => 'What is a pull request (PR)?', 'opts' => ['A request to download code', 'A proposal to merge changes from one branch into another', 'A command to pull latest changes', 'An automated deployment step'], 'correct' => 1, 'exp' => 'A pull request is a collaboration feature to review and discuss changes before merging.'],
                            ['q' => 'Which command discards all local uncommitted changes?', 'opts' => ['git clean', 'git reset --hard HEAD', 'git undo all', 'git restore --staged .'], 'correct' => 1, 'exp' => 'git reset --hard HEAD resets the working directory and staging area to the last commit.'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
