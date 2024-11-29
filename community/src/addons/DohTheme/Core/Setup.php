<?php
namespace DohTheme\Core;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
            $table->addColumn('node_background', 'varchar', 250)->setDefault('');
        }); 
	}

	public function upgrade(array $stepParams = [])
	{
		// TODO: Implement upgrade() method.
	}

	public function uninstall(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
            $table->dropColumns('node_background');
            
        });
	}
}