<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 24.04.18
 * Time: 11:47
 */

namespace app\models;


use yii\db\Migration;
use yii\db\SchemaBuilderTrait;

class ProvidersMigration extends Migration
{

    use SchemaBuilderTrait;

   

    
    /**
     * Creates and executes an INSERT SQL statement.
     * The method will properly escape the column names, and bind the values to be inserted.
     * @param string $table the table that new rows will be inserted into.
     * @param array $columns the column data (name => value) to be inserted into the table.
     */
    public function p_insert($table, $columns)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->insert('cl_'.$provider->provider_id.'_'.$table, $columns);
        }

    }

    /**
     * Creates and executes a batch INSERT SQL statement.
     * The method will properly escape the column names, and bind the values to be inserted.
     * @param string $table the table that new rows will be inserted into.
     * @param array $columns the column names.
     * @param array $rows the rows to be batch inserted into the table
     */
    public function p_batchInsert($table, $columns, $rows)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->batchInsert('cl_'.$provider->provider_id.'_'.$table, $columns, $rows);
        }

    }

    /**
     * Creates and executes a command to insert rows into a database table if
     * they do not already exist (matching unique constraints),
     * or update them if they do.
     *
     * The method will properly escape the column names, and bind the values to be inserted.
     *
     * @param string $table the table that new rows will be inserted into/updated in.
     * @param array|Query $insertColumns the column data (name => value) to be inserted into the table or instance
     * of [[Query]] to perform `INSERT INTO ... SELECT` SQL statement.
     * @param array|bool $updateColumns the column data (name => value) to be updated if they already exist.
     * If `true` is passed, the column data will be updated to match the insert column data.
     * If `false` is passed, no update will be performed if the column data already exists.
     * @param array $params the parameters to be bound to the command.
     * @return $this the command object itself.
     * @since 2.0.14
     */
    public function p_upsert($table, $insertColumns, $updateColumns = true, $params = [])
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->upsert('cl_'.$provider->provider_id.'_'.$table, $insertColumns, $updateColumns, $params);
        }
    }

    /**
     * Creates and executes an UPDATE SQL statement.
     * The method will properly escape the column names and bind the values to be updated.
     * @param string $table the table to be updated.
     * @param array $columns the column data (name => value) to be updated.
     * @param array|string $condition the conditions that will be put in the WHERE part. Please
     * refer to [[Query::where()]] on how to specify conditions.
     * @param array $params the parameters to be bound to the query.
     */
    public function p_update($table, $columns, $condition = '', $params = [])
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->update('cl_'.$provider->provider_id.'_'.$table, $columns, $condition , $params);
        }
    }

    /**
     * Creates and executes a DELETE SQL statement.
     * @param string $table the table where the data will be deleted from.
     * @param array|string $condition the conditions that will be put in the WHERE part. Please
     * refer to [[Query::where()]] on how to specify conditions.
     * @param array $params the parameters to be bound to the query.
     */
    public function p_delete($table, $condition = '', $params = [])
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->delete('cl_'.$provider->provider_id.'_'.$table, $condition = '', $params = []);
        }
    }

    /**
     * Builds and executes a SQL statement for creating a new DB table.
     *
     * The columns in the new  table should be specified as name-definition pairs (e.g. 'name' => 'string'),
     * where name stands for a column name which will be properly quoted by the method, and definition
     * stands for the column type which can contain an abstract DB type.
     *
     * The [[QueryBuilder::getColumnType()]] method will be invoked to convert any abstract type into a physical one.
     *
     * If a column is specified with definition only (e.g. 'PRIMARY KEY (name, type)'), it will be directly
     * put into the generated SQL.
     *
     * @param string $table the name of the table to be created. The name will be properly quoted by the method.
     * @param array $columns the columns (name => definition) in the new table.
     * @param string $options additional SQL fragment that will be appended to the generated SQL.
     */
    public function p_createTable($table, $columns, $options = null)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->createTable('cl_'.$provider->provider_id.'_'.$table, $columns, $options);
        }
    }

    /**
     * Builds and executes a SQL statement for renaming a DB table.
     * @param string $table the table to be renamed. The name will be properly quoted by the method.
     * @param string $newName the new table name. The name will be properly quoted by the method.
     */
    public function p_renameTable($table, $newName)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->renameTable('cl_'.$provider->provider_id.'_'.$table, $newName);
        }
    }

    /**
     * Builds and executes a SQL statement for dropping a DB table.
     * @param string $table the table to be dropped. The name will be properly quoted by the method.
     */
    public function p_dropTable($table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropTable('cl_'.$provider->provider_id.'_'.$table);
        }
    }

    /**
     * Builds and executes a SQL statement for truncating a DB table.
     * @param string $table the table to be truncated. The name will be properly quoted by the method.
     */
    public function p_truncateTable($table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->truncateTable('cl_'.$provider->provider_id.'_'.$table);
        }
    }

    /**
     * Builds and executes a SQL statement for adding a new DB column.
     * @param string $table the table that the new column will be added to. The table name will be properly quoted by the method.
     * @param string $column the name of the new column. The name will be properly quoted by the method.
     * @param string $type the column type. The [[QueryBuilder::getColumnType()]] method will be invoked to convert abstract column type (if any)
     * into the physical one. Anything that is not recognized as abstract type will be kept in the generated SQL.
     * For example, 'string' will be turned into 'varchar(255)', while 'string not null' will become 'varchar(255) not null'.
     */
    public function p_addColumn($table, $column, $type)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->addColumn('cl_'.$provider->provider_id.'_'.$table, $column, $type);
        }
    }

    /**
     * Builds and executes a SQL statement for dropping a DB column.
     * @param string $table the table whose column is to be dropped. The name will be properly quoted by the method.
     * @param string $column the name of the column to be dropped. The name will be properly quoted by the method.
     */
    public function p_dropColumn($table, $column)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropColumn('cl_'.$provider->provider_id.'_'.$table, $column);
        }
    }

    /**
     * Builds and executes a SQL statement for renaming a column.
     * @param string $table the table whose column is to be renamed. The name will be properly quoted by the method.
     * @param string $name the old name of the column. The name will be properly quoted by the method.
     * @param string $newName the new name of the column. The name will be properly quoted by the method.
     */
    public function p_renameColumn($table, $name, $newName)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->renameColumn('cl_'.$provider->provider_id.'_'.$table, $name, $newName);
        }
    }

    /**
     * Builds and executes a SQL statement for changing the definition of a column.
     * @param string $table the table whose column is to be changed. The table name will be properly quoted by the method.
     * @param string $column the name of the column to be changed. The name will be properly quoted by the method.
     * @param string $type the new column type. The [[QueryBuilder::getColumnType()]] method will be invoked to convert abstract column type (if any)
     * into the physical one. Anything that is not recognized as abstract type will be kept in the generated SQL.
     * For example, 'string' will be turned into 'varchar(255)', while 'string not null' will become 'varchar(255) not null'.
     */
    public function p_alterColumn($table, $column, $type)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->alterColumn('cl_'.$provider->provider_id.'_'.$table, $column, $type);
        }
    }

    /**
     * Builds and executes a SQL statement for creating a primary key.
     * The method will properly quote the table and column names.
     * @param string $name the name of the primary key constraint.
     * @param string $table the table that the primary key constraint will be added to.
     * @param string|array $columns comma separated string or array of columns that the primary key will consist of.
     */
    public function p_addPrimaryKey($name, $table, $columns)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->addPrimaryKey($name, 'cl_'.$provider->provider_id.'_'.$table, $columns);
        }
    }

    /**
     * Builds and executes a SQL statement for dropping a primary key.
     * @param string $name the name of the primary key constraint to be removed.
     * @param string $table the table that the primary key constraint will be removed from.
     */
    public function p_dropPrimaryKey($name, $table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropPrimaryKey($name, 'cl_'.$provider->provider_id.'_'.$table);
        }
    }

    /**
     * Builds a SQL statement for adding a foreign key constraint to an existing table.
     * The method will properly quote the table and column names.
     * @param string $name the name of the foreign key constraint.
     * @param string $table the table that the foreign key constraint will be added to.
     * @param string|array $columns the name of the column to that the constraint will be added on. If there are multiple columns, separate them with commas or use an array.
     * @param string $refTable the table that the foreign key references to.
     * @param string|array $refColumns the name of the column that the foreign key references to. If there are multiple columns, separate them with commas or use an array.
     * @param string $delete the ON DELETE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
     * @param string $update the ON UPDATE option. Most DBMS support these options: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
     */
    public function p_addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->addForeignKey($name, 'cl_'.$provider->provider_id.'_'.$table, $columns, $refTable, $refColumns, $delete, $update );
        }
    }

    /**
     * Builds a SQL statement for dropping a foreign key constraint.
     * @param string $name the name of the foreign key constraint to be dropped. The name will be properly quoted by the method.
     * @param string $table the table whose foreign is to be dropped. The name will be properly quoted by the method.
     */
    public function p_dropForeignKey($name, $table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropForeignKey($name, 'cl_'.$provider->provider_id.'_'.$table);
        }
    }

    /**
     * Builds and executes a SQL statement for creating a new index.
     * @param string $name the name of the index. The name will be properly quoted by the method.
     * @param string $table the table that the new index will be created for. The table name will be properly quoted by the method.
     * @param string|array $columns the column(s) that should be included in the index. If there are multiple columns, please separate them
     * by commas or use an array. Each column name will be properly quoted by the method. Quoting will be skipped for column names that
     * include a left parenthesis "(".
     * @param bool $unique whether to add UNIQUE constraint on the created index.
     */
    public function p_createIndex($name, $table, $columns, $unique = false)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->createIndex($name, 'cl_'.$provider->provider_id.'_'.$table, $columns, $unique);
        }
    }

    /**
     * Builds and executes a SQL statement for dropping an index.
     * @param string $name the name of the index to be dropped. The name will be properly quoted by the method.
     * @param string $table the table whose index is to be dropped. The name will be properly quoted by the method.
     */
    public function p_dropIndex($name, $table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropIndex($name, 'cl_'.$provider->provider_id.'_'.$table);
        }
    }

    /**
     * Builds and execute a SQL statement for adding comment to column.
     *
     * @param string $table the table whose column is to be commented. The table name will be properly quoted by the method.
     * @param string $column the name of the column to be commented. The column name will be properly quoted by the method.
     * @param string $comment the text of the comment to be added. The comment will be properly quoted by the method.
     * @since 2.0.8
     */
    public function p_addCommentOnColumn($table, $column, $comment)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->addCommentOnColumn('cl_'.$provider->provider_id.'_'.$table, $column, $comment);
        }
    }

    /**
     * Builds a SQL statement for adding comment to table.
     *
     * @param string $table the table to be commented. The table name will be properly quoted by the method.
     * @param string $comment the text of the comment to be added. The comment will be properly quoted by the method.
     * @since 2.0.8
     */
    public function p_addCommentOnTable($table, $comment)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->addCommentOnTable('cl_'.$provider->provider_id.'_'.$table, $comment);
        }
    }

    /**
     * Builds and execute a SQL statement for dropping comment from column.
     *
     * @param string $table the table whose column is to be commented. The table name will be properly quoted by the method.
     * @param string $column the name of the column to be commented. The column name will be properly quoted by the method.
     * @since 2.0.8
     */
    public function p_dropCommentFromColumn($table, $column)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropCommentFromColumn('cl_'.$provider->provider_id.'_'.$table, $column);
        }
    }

    /**
     * Builds a SQL statement for dropping comment from table.
     *
     * @param string $table the table whose column is to be commented. The table name will be properly quoted by the method.
     * @since 2.0.8
     */
    public function p_dropCommentFromTable($table)
    {
        foreach (\app\models\Providers::find()->all() as $provider){
            $this->dropCommentFromTable('cl_'.$provider->provider_id.'_'.$table);
        }
    }


}

