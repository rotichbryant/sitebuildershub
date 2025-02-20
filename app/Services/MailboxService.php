<?php
namespace App\Services;

use Ddeboer\Imap\Server;
use Ddeboer\Imap\Exception\AuthenticationFailedException;
use Ddeboer\Imap\Exception\ImapGetmailboxesException;

class MailboxService{
    
    private $server;

    private $connection;

    private $email_address;
    
    private $password;
    
    /**
     * Establish a connection to the IMAP server.
     *
     * This constructor accepts the email address, password, host, and port
     * information for the IMAP server. These values are used to create a
     * Ddeboer\Imap\Server instance which is used for further operations on the
     * mailbox.
     *
     * @param string $email_address The email address of the mailbox
     * @param string $password The password for the mailbox
     * @param string $host The host of the IMAP server
     * @param int $port The port to use when connecting to the IMAP server
     */
    function __construct(String $email_address,String $password,String $host, Int $port) {
        $this->email_address = $email_address;
        $this->password      = $password;
        $this->server        = new Server($host,$port);
        $this->connect();
    }

    /**
     * Establish a connection to the IMAP server.
     *
     * This method initializes the PhpImap\Mailbox instance which is used for performing
     * operations on the mailbox. It sets up the connection using the provided host,
     * email address, and password.
     *
     * @return void
     */
    protected function connect():void {
        try{
            // Authenticate with the IMAP server
            $this->connection = $this->server->authenticate($this->email_address, $this->password);
        } catch (AuthenticationFailedException $error) {
            print_r($error);
        }
    }

    /**
     * Return an array of all mailboxes in the IMAP account.
     *
     * Uses the Ddeboer\Imap\Server::getMailboxes() method to return an array of all
     * mailboxes in the IMAP account. This method will throw an
     * ImapGetmailboxesException if it fails to retrieve the mailboxes.
     *
     * @return array An array of all mailboxes in the IMAP account
     */
    public function mailboxes():array {
        try {

            $mailboxes = array();

            foreach ($this->connection->getMailboxes() as $mailbox) {
                // Skip container-only mailboxes
                // @see https://secure.php.net/manual/en/function.imap-getmailboxes.php
                if ($mailbox->getAttributes() & \LATT_NOSELECT) {
                    continue;
                }
            
                $mailboxes[$mailbox->getName()] = $mailbox->count();
                // $mailbox is instance of \Ddeboer\Imap\Mailbox
                // printf('Mailbox "%s" has %s messages', $mailbox->getName(), $mailbox->count());
            }
            
            return $mailboxes;

        } catch(ImapGetmailboxesException $error) {
            // If the connection fails, print the error and stop execution
            print($error);
            // TODO: Handle the error more gracefully
            die();
        }
    }

    /**
     * Return an array of all mailboxes in the IMAP account.
     *
     * Uses the Ddeboer\Imap\Server::getMailboxes() method to return an array of all
     * mailboxes in the IMAP account. This method will throw an
     * ImapGetmailboxesException if it fails to retrieve the mailboxes.
     *
     * @return array An array of all mailboxes in the IMAP account
     */
    public function mailbox(string $name = 'INBOX'): array {
        try {

            $mailbox = $this->connection->getMailbox($name);
            // $messages = array();

            // foreach($this->connection->getMailbox($name) as $mailbox) {
            //     // print_r( $mailbox);
            //     $messages[] = $mailbox->getRawMessage();
            // }
            
            return array(
                'attributes' => $mailbox->getAttributes(),
                'count'      => $mailbox->count(),
                'name'       => $mailbox->getName(),
                'messages'   => $mailbox->getMessages(),
                'status'     => $mailbox->getStatus()
            );

        } catch(ImapGetmailboxesException $error) {
            // If the connection fails, print the error and stop execution
            print($error);
            // TODO: Handle the error more gracefully
            die();
        }
    }   
    
    /**
     * Retrieve all messages in the mailbox.
     *
     * Uses the Ddeboer\Imap\Connection::getMessages() method to retrieve an array of all
     * messages in the mailbox. This method will throw an
     * ImapGetmailboxesException if it fails to retrieve the messages.
     *
     * @return array An array of all messages in the mailbox
     */
    public function ping(): bool {
        try {
            // Retrieve an array of all messages in the mailbox
            return $this->connection->ping();
        } catch(ImapGetmailboxesException $error) {
            // If the connection fails, print the error and stop execution
            print($error);
            // TODO: Handle the error more gracefully
            die();
        }
    }
}