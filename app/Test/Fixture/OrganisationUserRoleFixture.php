<?php
	/**
	 * Code source de la classe OrganisationUserRoleFixture.
	 *
	 * PHP 5.3
	 *
	 * @package app.Test.Fixture
	 * @license CeCiLL V2 (http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html)
	 */
	/**
	 * La classe OrganisationUserRoleFixture ...
	 *
	 * @package app.Test.Fixture
	 */
	class OrganisationUserRoleFixture extends CakeTestFixture
	{

		/**
		 * On importe la définition de la table, pas les enregistrements.
		 *
		 * @var array
		 */
		public $import = [
			'model' => 'OrganisationUserRole',
			'records' => false
		];

		/**
		 * Définition des enregistrements.
		 *
		 * @var array
		 */
		public $records = [
			2 => [
				'organisation_user_id' => 2,
				'role_id' => 4,
				'created' => '2017-07-25 09:08:46',
				'modified' => '2017-07-25 09:08:46',
			],
			3 => [
				'organisation_user_id' => 3,
				'role_id' => 3,
				'created' => '2017-07-25 09:08:49',
				'modified' => '2017-07-25 09:08:49',
			],
			4 => [
				'organisation_user_id' => 4,
				'role_id' => 3,
				'created' => '2017-07-25 09:08:52',
				'modified' => '2017-07-25 09:08:52',
			],
			5 => [
				'organisation_user_id' => 5,
				'role_id' => 2,
				'created' => '2017-07-25 09:08:55',
				'modified' => '2017-07-25 09:08:55',
			],
			6 => [
				'organisation_user_id' => 6,
				'role_id' => 7,
				'created' => '2017-07-25 09:08:58',
				'modified' => '2017-07-25 09:08:58',
			],
			8 => [
				'organisation_user_id' => 8,
				'role_id' => 4,
				'created' => '2017-07-25 09:09:01',
				'modified' => '2017-07-25 09:09:01',
			],
			9 => [
				'organisation_user_id' => 7,
				'role_id' => 4,
				'created' => '2017-07-25 09:09:22',
				'modified' => '2017-07-25 09:09:22',
			],
			10 => [
				'organisation_user_id' => 1,
				'role_id' => 4,
				'created' => '2017-07-25 09:09:37',
				'modified' => '2017-07-25 09:09:37',
			]
		];
	}
?>