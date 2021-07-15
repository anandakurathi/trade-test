<?php


namespace Src\Config;

/*
    Use the static method getInstance to get the object.
*/
class Session
{
    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;

    // The state of the session
    private static $instance;

    // THE only instance of the class
    private $sessionState = self::SESSION_NOT_STARTED;

    /**
     *  Returns THE instance of 'Session'.
     *  The session is automatically initialized if it wasn't.
     *
     * @return object
     **/

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }


    /**
     * (Re)starts the session.
     *
     * @return bool TRUE if the session has been initialized, else FALSE.
     **/

    public function startSession(): bool
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    /**
     *    Gets data from the session.
     *    Example: echo $instance->foo;
     *
     * @param string $name Name of the data to get.
     * @return mixed Data stored in session.
     **/

    public function __get(string $name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    /**
     *    Stores data in the session.
     *    Example: $instance->foo = 'bar';
     *
     * @param string $name Name of the data.
     * @param string $value Your data.
     * @return    void
     **/

    public function __set(string $name, string $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Destroys the current session.
     *
     * @return bool TRUE is session has been deleted, else FALSE.
     **/

    public function destroy(): bool
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return false;
    }
}