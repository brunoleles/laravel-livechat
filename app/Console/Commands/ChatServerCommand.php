<?php

namespace App\Console\Commands;

use App\Support\ChatServer\ChatServer;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;

class ChatServerCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'le:chat-server';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Starts the chat server';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {

		$server = IoServer::factory(
						new \Ratchet\Http\HttpServer(
								new \Ratchet\WebSocket\WsServer(
										new ChatServer())),
						81
		);

		$server->run();
	}

}
