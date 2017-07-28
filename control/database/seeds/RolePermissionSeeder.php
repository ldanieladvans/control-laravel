<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;
use App\Distributor;
use App\Domicile;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    
	public function createroles(){
		$roles = array();
		$appRole = Role::create([
		    'name' => 'App',
		    'slug' => 'app',
		]);
		$roles['appRole'] = $appRole;

		$apiRole = Role::create([
		    'name' => 'Api',
		    'slug' => 'api',
		]);
		$roles['apiRole'] = $apiRole;

		$factRole = Role::create([
            'name' => 'Facturación',
            'slug' => 'fact',
            'description' => 'Ejecuta todas las tareas relacionadas a la facturación',
        ]);
        $roles['factRole'] = $factRole;

        $superGeneralRole = Role::create([
            'name' => 'Super General',
            'slug' => 'super.general',
            'description' => 'Ejecuta todas las tareas',
        ]);
        $roles['superGeneralRole'] = $superGeneralRole;

        $ventasRole = Role::create([
            'name' => 'Ventas',
            'slug' => 'ventas',
            'description' => 'Ejecuta las tareas relacionadas a los procesos de venta',
        ]);
        $roles['ventasRole'] = $ventasRole;

        $distributorRole = Role::create([
            'name' => 'Distribuidor',
            'slug' => 'distribuidor',
            'description' => 'Ejecuta las tareas relacionadas a los distribuidores',
        ]);
        $roles['distributorRole'] = $distributorRole;

        $sopTecRole = Role::create([
            'name' => 'Soporte Técnico',
            'slug' => 'soporte.tecnico',
            'description' => 'Ejecuta las tareas relacionadas a al soporte de los usuarios',
        ]);
        $roles['sopTecRole'] = $sopTecRole;

        $auditRole = Role::create([
            'name' => 'Auditor',
            'slug' => 'auditor',
            'description' => 'Ejecuta las tareas relacionadas a la revision de la bitacora',
        ]);
        $roles['auditRole'] = $auditRole;

        $aistSopTecRole = Role::create([
            'name' => 'Asistente Soporte Técnico',
            'slug' => 'asist.soporte.tecnico',
            'description' => 'Ejecuta las tareas relacionadas a al soporte de los usuarios',
        ]);
        $roles['aistSopTecRole'] = $aistSopTecRole;

		//return $appRole->id;
		return $roles;
	}

	public function createpermissions(){
		$perms = array();
		//Distributor Perms
		$distReadPermission = Permission::create([
		    'name' => 'Ver distribuidores',
		    'slug' => 'see.dist',
		]);
		$perms['distReadPermission'] = $distReadPermission;

		$distCreatePermission = Permission::create([
		    'name' => 'Crear distribuidores',
		    'slug' => 'create.dist',
		]);
		$perms['distCreatePermission'] = $distCreatePermission;

		$distEditPermission = Permission::create([
		    'name' => 'Editar distribuidores',
		    'slug' => 'edit.dist',
		]);
		$perms['distEditPermission'] = $distEditPermission;

		$distDeletePermission = Permission::create([
		    'name' => 'Borrar distribuidores',
		    'slug' => 'delete.dist',
		]);
		$perms['distDeletePermission'] = $distDeletePermission;

		//Clients Perms
		$clientReadPermission = Permission::create([
		    'name' => 'Ver clientes',
		    'slug' => 'see.clients',
		]);
		$perms['clientReadPermission'] = $clientReadPermission;

		$clientsCreatePermission = Permission::create([
		    'name' => 'Crear clientes',
		    'slug' => 'create.clients',
		]);
		$perms['clientsCreatePermission'] = $clientsCreatePermission;

		$clientsEditPermission = Permission::create([
		    'name' => 'Editar clientes',
		    'slug' => 'edit.clients',
		]);
		$perms['clientsEditPermission'] = $clientsEditPermission;

		$clientsDeletePermission = Permission::create([
		    'name' => 'Borrar clientes',
		    'slug' => 'delete.clients',
		]);
		$perms['clientsDeletePermission'] = $clientsDeletePermission;

		//Dist Assigs Perms
		$distAssigsReadPermission = Permission::create([
		    'name' => 'Ver asignaciones',
		    'slug' => 'see.assigs',
		]);
		$perms['distAssigsReadPermission'] = $distAssigsReadPermission;

		$distAssigsCreatePermission = Permission::create([
		    'name' => 'Crear asignaciones',
		    'slug' => 'create.assigs',
		]);
		$perms['distAssigsCreatePermission'] = $distAssigsCreatePermission;

		$distAssigsEditPermission = Permission::create([
		    'name' => 'Editar asignaciones',
		    'slug' => 'edit.assigs',
		]);
		$perms['distAssigsEditPermission'] = $distAssigsEditPermission;

		$distAssigsDeletePermission = Permission::create([
		    'name' => 'Borrar asignaciones',
		    'slug' => 'delete.assigs',
		]);
		$perms['distAssigsDeletePermission'] = $distAssigsDeletePermission;

		//Account Perms
		$accReadPermission = Permission::create([
		    'name' => 'Ver cuentas',
		    'slug' => 'see.accounts',
		]);
		$perms['accReadPermission'] = $accReadPermission;

		$accCreatePermission = Permission::create([
		    'name' => 'Crear cuentas',
		    'slug' => 'create.accounts',
		]);
		$perms['accCreatePermission'] = $accCreatePermission;

		$accEditPermission = Permission::create([
		    'name' => 'Editar cuentas',
		    'slug' => 'edit.accounts',
		]);
		$perms['accEditPermission'] = $accEditPermission;

		$accDeletePermission = Permission::create([
		    'name' => 'Borrar cuentas',
		    'slug' => 'delete.accounts',
		]);
		$perms['accDeletePermission'] = $accDeletePermission;

		$accActDeactPermission = Permission::create([
		    'name' => 'Cambiar estado cuentas',
		    'slug' => 'change.state.accounts',
		]);
		$perms['accActDeactPermission'] = $accActDeactPermission;

		$accSeeBitPermission = Permission::create([
		    'name' => 'Ver bitácora de cuentas',
		    'slug' => 'see.bit.accounts',
		]);
		$perms['accSeeBitPermission'] = $accSeeBitPermission;

		$accUnlockUsersPermission = Permission::create([
		    'name' => 'Desbloquear usuarios de cuentas',
		    'slug' => 'unlock.users.accounts',
		]);
		$perms['accUnlockUsersPermission'] = $accUnlockUsersPermission;

		$accChangePeriodPermission = Permission::create([
		    'name' => 'Cambiar periodicidad de cuentas',
		    'slug' => 'change.period.accounts',
		]);
		$perms['accChangePeriodPermission'] = $accChangePeriodPermission;

		$accChangeRecPermission = Permission::create([
		    'name' => 'Cambiar recursividad de cuentas',
		    'slug' => 'change.rec.accounts',
		]);
		$perms['accChangeRecPermission'] = $accChangeRecPermission;

		$accCrudDetailsPermission = Permission::create([
		    'name' => 'Gestionar detalles de cuentas',
		    'slug' => 'manage.details.accounts',
		]);
		$perms['accCrudDetailsPermission'] = $accCrudDetailsPermission;

		$accCrudTlsPermission = Permission::create([
		    'name' => 'Gestionar fechas de cuentas',
		    'slug' => 'manage.tls.accounts',
		]);
		$perms['accCrudTlsPermission'] = $accCrudTlsPermission;

		//App Perms
		$appsReadPermission = Permission::create([
		    'name' => 'Ver aplicaciones',
		    'slug' => 'see.apps',
		]);
		$perms['appsReadPermission'] = $appsReadPermission;

		$appsCreatePermission = Permission::create([
		    'name' => 'Crear aplicaciones',
		    'slug' => 'create.apps',
		]);
		$perms['appsCreatePermission'] = $appsCreatePermission;

		$appsEditPermission = Permission::create([
		    'name' => 'Editar aplicaciones',
		    'slug' => 'edit.apps',
		]);
		$perms['appsEditPermission'] = $appsEditPermission;

		$appsDeletePermission = Permission::create([
		    'name' => 'Borrar aplicaciones',
		    'slug' => 'delete.apps',
		]);
		$perms['appsDeletePermission'] = $appsDeletePermission;

		//User Perms
		$usersReadPermission = Permission::create([
		    'name' => 'Ver usuarios',
		    'slug' => 'see.users',
		]);
		$perms['usersReadPermission'] = $usersReadPermission;

		$usersCreatePermission = Permission::create([
		    'name' => 'Crear usuarios',
		    'slug' => 'create.users',
		]);
		$perms['usersCreatePermission'] = $usersCreatePermission;

		$usersEditPermission = Permission::create([
		    'name' => 'Editar usuarios',
		    'slug' => 'edit.users',
		]);
		$perms['usersEditPermission'] = $usersEditPermission;

		$usersDeletePermission = Permission::create([
		    'name' => 'Borrar usuarios',
		    'slug' => 'delete.users',
		]);
		$perms['usersDeletePermission'] = $usersDeletePermission;

		$usersChangePassPermission = Permission::create([
		    'name' => 'Cambiar contraseña de usuarios',
		    'slug' => 'change.password.users',
		]);
		$perms['usersChangePassPermission'] = $usersChangePassPermission;

		$usersAssignRolePermission = Permission::create([
		    'name' => 'Asignar roles a usuarios',
		    'slug' => 'assign.roles.users',
		]);
		$perms['usersAssignRolePermission'] = $usersAssignRolePermission;

		$usersAssignPermsPermission = Permission::create([
		    'name' => 'Asignar permisos a usuarios',
		    'slug' => 'assign.perms.users',
		]);
		$perms['usersAssignPermsPermission'] = $usersAssignPermsPermission;

		//Role Perms
		$rolesReadPermission = Permission::create([
		    'name' => 'Ver roles',
		    'slug' => 'see.roles',
		]);
		$perms['rolesReadPermission'] = $rolesReadPermission;

		$rolesCreatePermission = Permission::create([
		    'name' => 'Crear roles',
		    'slug' => 'create.roles',
		]);
		$perms['rolesCreatePermission'] = $rolesCreatePermission;

		$rolesEditPermission = Permission::create([
		    'name' => 'Editar roles',
		    'slug' => 'edit.roles',
		]);
		$perms['rolesEditPermission'] = $rolesEditPermission;

		$rolesDeletePermission = Permission::create([
		    'name' => 'Borrar roles',
		    'slug' => 'delete.roles',
		]);
		$perms['rolesDeletePermission'] = $rolesDeletePermission;

		$rolesAssignPermsPermission = Permission::create([
		    'name' => 'Asignar permisos a roles',
		    'slug' => 'assign.perms.roles',
		]);
		$perms['rolesAssignPermsPermission'] = $rolesAssignPermsPermission;

		//Perm Perms
		$permsReadPermission = Permission::create([
		    'name' => 'Ver permisos',
		    'slug' => 'see.perms',
		]);
		$perms['permsReadPermission'] = $permsReadPermission;

		$permsCreatePermission = Permission::create([
		    'name' => 'Crear permisos',
		    'slug' => 'create.perms',
		]);
		$perms['permsCreatePermission'] = $permsCreatePermission;

		$permsEditPermission = Permission::create([
		    'name' => 'Editar permisos',
		    'slug' => 'edit.perms',
		]);
		$perms['permsEditPermission'] = $permsEditPermission;

		//Bit Perms
		$permsReadPermission = Permission::create([
		    'name' => 'Ver bitácora',
		    'slug' => 'see.bit',
		]);
		$perms['permsReadPermission'] = $permsReadPermission;

		//News Perms
		$newsReadPermission = Permission::create([
		    'name' => 'Ver noticias',
		    'slug' => 'see.news',
		]);
		$perms['newsReadPermission'] = $newsReadPermission;

		$newsCreatePermission = Permission::create([
		    'name' => 'Crear noticias',
		    'slug' => 'create.news',
		]);
		$perms['newsCreatePermission'] = $newsCreatePermission;

		$newsEditPermission = Permission::create([
		    'name' => 'Editar noticias',
		    'slug' => 'edit.news',
		]);
		$perms['newsEditPermission'] = $newsEditPermission;

		$newsDeletePermission = Permission::create([
		    'name' => 'Borrar noticias',
		    'slug' => 'delete.news',
		]);
		$perms['newsDeletePermission'] = $newsDeletePermission;

		//Art69 Perms
		$artsReadPermission = Permission::create([
		    'name' => 'Ver lista de artículo 69',
		    'slug' => 'see.art',
		]);
		$perms['artsReadPermission'] = $artsReadPermission;

		$artsCreatePermission = Permission::create([
		    'name' => 'Crear entrada de artículo 69',
		    'slug' => 'create.art',
		]);
		$perms['artsCreatePermission'] = $artsCreatePermission;

		$artsEditPermission = Permission::create([
		    'name' => 'Editar entrada de artículo 69',
		    'slug' => 'edit.art',
		]);
		$perms['artsEditPermission'] = $artsEditPermission;

		$artsDeletePermission = Permission::create([
		    'name' => 'Borrar entrada de artículo 69',
		    'slug' => 'delete.art',
		]);
		$perms['artsDeletePermission'] = $artsDeletePermission;

		//Ref Perms
		$refReadPermission = Permission::create([
		    'name' => 'Ver referenciador',
		    'slug' => 'see.ref',
		]);
		$perms['refReadPermission'] = $refReadPermission;

		$refCreatePermission = Permission::create([
		    'name' => 'Crear referenciador',
		    'slug' => 'create.ref',
		]);
		$perms['refCreatePermission'] = $refCreatePermission;

		return $perms;

	}

	public function assignrolesperms($roles,$perms){
		//Facturacion
		$roles['factRole']->attachPermission($perms['accReadPermission']);
		$roles['factRole']->attachPermission($perms['accEditPermission']);
		$roles['factRole']->attachPermission($perms['accActDeactPermission']);
		$roles['factRole']->attachPermission($perms['accChangePeriodPermission']);
		$roles['factRole']->attachPermission($perms['accChangeRecPermission']);
		$roles['factRole']->attachPermission($perms['accCrudDetailsPermission']);
		$roles['factRole']->attachPermission($perms['accCrudTlsPermission']);

		$roles['factRole']->attachPermission($perms['distReadPermission']);
		$roles['factRole']->attachPermission($perms['distEditPermission']);

		$roles['factRole']->attachPermission($perms['clientReadPermission']);
		$roles['factRole']->attachPermission($perms['clientsCreatePermission']);
		$roles['factRole']->attachPermission($perms['clientsEditPermission']);

		$roles['factRole']->attachPermission($perms['newsReadPermission']);

		$roles['factRole']->attachPermission($perms['refReadPermission']);
		$roles['factRole']->attachPermission($perms['refCreatePermission']);

		//Super General
		foreach ($perms as $key => $value) {
			$roles['superGeneralRole']->attachPermission($value);
		}

		//Ventas
		$roles['ventasRole']->attachPermission($perms['distReadPermission']);

		$roles['ventasRole']->attachPermission($perms['clientReadPermission']);
		$roles['ventasRole']->attachPermission($perms['clientsCreatePermission']);
		$roles['ventasRole']->attachPermission($perms['clientsEditPermission']);

		$roles['ventasRole']->attachPermission($perms['refReadPermission']);

		//Distribuidor
		//TODO Preguntar porque no tiene ningun permiso

		//Soporte Técnico
		$roles['sopTecRole']->attachPermission($perms['accReadPermission']);
		$roles['sopTecRole']->attachPermission($perms['accEditPermission']);
		$roles['sopTecRole']->attachPermission($perms['accSeeBitPermission']);
		$roles['sopTecRole']->attachPermission($perms['accActDeactPermission']);
		$roles['sopTecRole']->attachPermission($perms['accChangePeriodPermission']);
		$roles['sopTecRole']->attachPermission($perms['accChangeRecPermission']);
		$roles['sopTecRole']->attachPermission($perms['accCrudDetailsPermission']);
		$roles['sopTecRole']->attachPermission($perms['accCrudTlsPermission']);

		$roles['sopTecRole']->attachPermission($perms['clientReadPermission']);
		$roles['sopTecRole']->attachPermission($perms['clientsCreatePermission']);
		$roles['sopTecRole']->attachPermission($perms['clientsEditPermission']);

		$roles['sopTecRole']->attachPermission($perms['newsReadPermission']);

		$roles['sopTecRole']->attachPermission($perms['permsReadPermission']);

		//Auditor
		$roles['auditRole']->attachPermission($perms['distReadPermission']);

		$roles['auditRole']->attachPermission($perms['clientReadPermission']);

		$roles['auditRole']->attachPermission($perms['distAssigsReadPermission']);

		$roles['auditRole']->attachPermission($perms['accReadPermission']);

		$roles['auditRole']->attachPermission($perms['appsReadPermission']);

		$roles['auditRole']->attachPermission($perms['usersReadPermission']);

		$roles['auditRole']->attachPermission($perms['rolesReadPermission']);

		$roles['auditRole']->attachPermission($perms['permsReadPermission']);

		$roles['auditRole']->attachPermission($perms['permsReadPermission']);

		$roles['auditRole']->attachPermission($perms['newsReadPermission']);

		$roles['auditRole']->attachPermission($perms['artsReadPermission']);

		//Asistente Soporte Técnico
		$roles['aistSopTecRole']->attachPermission($perms['accReadPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accEditPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accCreatePermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accSeeBitPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accActDeactPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accChangePeriodPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accChangeRecPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accCrudDetailsPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['accCrudTlsPermission']);

		$roles['aistSopTecRole']->attachPermission($perms['clientReadPermission']);
		$roles['aistSopTecRole']->attachPermission($perms['clientsCreatePermission']);
		$roles['aistSopTecRole']->attachPermission($perms['clientsEditPermission']);

		$roles['aistSopTecRole']->attachPermission($perms['newsReadPermission']);

		$roles['aistSopTecRole']->attachPermission($perms['permsReadPermission']);
	}

	public function createsuperuser($app_role_id,$api_role_id,$gen_role_id){

		$adminUser = User::create([
		    'name' => 'Admin',
		    'usrc_nick' => 'admin',
		    'email' => 'control.admin@advans.mx', 
		    'password' => bcrypt('Admin123*'),
		    'usrc_admin' => 1, 
		    'usrc_type' => 'app'
		]);

		$apiUser = User::create([
		    'name' => 'Api Cuenta',
		    'usrc_nick' => 'api.cuenta',
		    'email' => 'api.cuenta@gmail.com', 
		    'password' => bcrypt('Api.cuenta123*'),
		    'usrc_type' => 'api'
		]);

		DB::table('role_user')->insert([
            ['role_id' => $app_role_id, 'user_id' => $adminUser->id, 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
        ]);

        DB::table('role_user')->insert([
            ['role_id' => $gen_role_id, 'user_id' => $adminUser->id, 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
        ]);

        DB::table('role_user')->insert([
            ['role_id' => $api_role_id, 'user_id' => $apiUser->id, 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]
        ]);
	}

	public function createAdvansDistrib(){
		$advansDistDom = Domicile::create([
		    'dom_calle' => '1-A x 42 y 44',
		    'dom_numext' => '334',
		    'dom_col' => 'Campestre',
		    'dom_ciudad' => 'Mérida',
		    'dom_munic' => '050',
		    'dom_estado' => 'Yucatán',
		    'dom_pais' => 'México',
		    'dom_cp' => '97120',
		]);

		$advansDist = Distributor::create([
		    'distrib_nom' => 'Advans',
		    'distrib_rfc' => 'SAD110722MQA',
		    'distrib_limitgig' => 999999,
		    'distrib_limitrfc' => 999999,
		    'distrib_tel' => '01 800 841-6655',
		    'distrib_correo' => 'info@advans.mx',
		    'distrib_nac' => 'Mexicana',
		    'distrib_sup' => 1,
		    'distrib_dom_id' => $advansDistDom->id,
		]);
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = $this->createroles();
        $perms = $this->createpermissions();
        $this->assignrolesperms($roles,$perms);
        $this->createsuperuser($roles['appRole']->id,$roles['apiRole']->id,$roles['superGeneralRole']->id);
        $this->createAdvansDistrib();
    }
}
