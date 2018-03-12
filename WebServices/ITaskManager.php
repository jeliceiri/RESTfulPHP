<?php
interface ITaskManager
{
		public function create($username, $desc);
		public function readById($username, $id);
		public function read($username);
		public function update($username, $id, $newDesc);
		public function delete($username, $id);
}
?>
