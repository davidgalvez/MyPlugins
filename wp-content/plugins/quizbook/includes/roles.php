<?php
if(! defined('ABSPATH')) exit();
/**
 * Clase para crear y remover roles
 */
class quizbookRoles{

	private string $rolName;
	private string $displayName;

	function __construct(string $rolName, string $displayName)
	{
		$this->rolName=$rolName;
		$this->displayName=$displayName;
	}

	function getRolName(){
		return $this->rolName;
	}

	function getRolDisplayName(){
		return $this->displayName;
	}

	function createRol(){
		add_role($this->rolName, $this->displayName);
	}

	function removeRol(){
		remove_role($this->rolName, $this->displayName);
	}

	function addCapabilities(){
		$roles = array( 'administrator', 'editor', 'quizbook' );

		foreach( $roles as $the_role ) {
			$role = get_role( $the_role );
			$role->add_cap( 'read' );
			$role->add_cap( 'edit_quizes' );
			$role->add_cap( 'publish_quizes' );
			$role->add_cap( 'edit_published_quizes' );
			$role->add_cap( 'edit_others_quizes' );

		}

		$manager_roles = array( 'administrator', 'editor' );

		foreach( $manager_roles as $the_role ) {
			$role = get_role( $the_role );
			$role->add_cap( 'read_private_quizes' );
			$role->add_cap( 'edit_others_quizes' );
			$role->add_cap( 'edit_private_quizes' );
			$role->add_cap( 'delete_quizes' );
			$role->add_cap( 'delete_published_quizes' );
			$role->add_cap( 'delete_private_quizes' );
			$role->add_cap( 'delete_others_quizes' );
		}
	}

	function removeCapabilities(){
		$manager_roles = array( 'administrator', 'editor' );

		foreach( $manager_roles as $the_role ) {
			$role = get_role( $the_role );
			$role->remove_cap( 'read' );
			$role->remove_cap( 'edit_quizes' );
			$role->remove_cap( 'publish_quizes' );
			$role->remove_cap( 'edit_published_quizes' );
			$role->remove_cap( 'read_private_quizes' );
			$role->remove_cap( 'edit_others_quizes' );
			$role->remove_cap( 'edit_private_quizes' );
			$role->remove_cap( 'delete_quizes' );
			$role->remove_cap( 'delete_published_quizes' );
			$role->remove_cap( 'delete_private_quizes' );
			$role->remove_cap( 'delete_others_quizes' );
		}
	}
}

?>