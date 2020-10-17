<?php

   namespace Grayl\Utility\Helper;

   use Grayl\Mixin\Common\Traits\StaticTrait;

   /**
    * A simple helper utility to handle working with PHP sessions
    *
    * @package Grayl\Utility
    */
   class SessionHelper
   {

      // Use the static instance trait
      use StaticTrait;

      /**
       * Tracks if the session has already been started previously
       *
       * @var bool
       */
      private bool $session_started;


      /**
       * The class constructor
       */
      public function __construct ()
      {

         // Start the session if it isn't already running
         if ( ! $this->isSessionStarted() ) {
            // Start the session
            $this->startSession();
         }
      }


      /**
       * Checks to see if the session has been started in PHP
       *
       * @return bool
       */
      private function isSessionStarted (): bool
      {

         // If the session is started
         if ( $this->session_started || session_status() === PHP_SESSION_ACTIVE ) {
            // Session running
            return true;
         }

         // Not running
         return false;
      }


      /**
       * Starts the PHP session
       *
       * @return bool
       */
      private function startSession (): bool
      {

         // Start the session
         $this->session_started = session_start();

         // Return the result
         return $this->session_started;
      }


      /**
       * Retrieves a stored session variable
       *
       * @param string $key The key of the stored session variable to get
       *
       * @return mixed
       */
      public function getSessionVariable ( string $key )
      {

         // If we have a value for this variable stored in this session...
         if ( ! empty( $_SESSION[ $key ] ) ) {
            // Value found
            return $_SESSION[ $key ];
         }

         // Nothing found
         return null;
      }


      /**
       * Sets a variable to the session
       *
       * @param string $key   The key of the stored session variable to set
       * @param mixed  $value The value to store for the variable
       */
      public function setSessionVariable ( string $key,
                                           $value ): void
      {

         // Save the variable to the session
         $_SESSION[ $key ] = $value;
      }


      /**
       * Deletes a variable from the session
       *
       * @param string $key The key of the stored session variable to destroy
       */
      public function deleteSessionVariable ( string $key ): void
      {

         // Unset the variable
         unset( $_SESSION[ $key ] );
      }


      /**
       * Destroys the session and deletes all variables
       */
      public function destroySession (): void
      {

         // Reset the session variables
         $_SESSION = [];

         // Destroy the session completely if needed
         if ( session_status() == PHP_SESSION_ACTIVE ) {
            // Nuclear option
            session_destroy();
         }
      }

   }