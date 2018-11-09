<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/8/9
 * Time: 下午4:46
 */

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;

/**
 * log server
 *
 * @package app.Providers
 */
class LogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('log', function () {
            return $this->createAppLogger();
        });
        $this->app->singleton('sql-log', function () {
            return $this->createSqlLogger();
        });
        $this->app->singleton('mail-log', function () {
            return $this->createMailLogger();
        });
        $this->app->singleton('request-log', function () {
            return $this->createRequestLogger();
        });
        $this->app->singleton('response-log', function () {
            return $this->createResponseLogger();
        });
    }
    /**
     * Create the app logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createAppLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureHandler($log, 'app');
        return $log;
    }

    /**
     * Create the sql logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createSqlLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureDailyHandler($log, 'sql');
        return $log;
    }
    /**
     * Create the mail logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createMailLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureDailyHandler($log, 'mail');
        return $log;
    }
    /**
     * Create the request logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createRequestLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureDailyHandler($log, 'request');
        return $log;
    }
    /**
     * Create the response logger.
     *
     * @return \Illuminate\Log\Writer
     */
    public function createResponseLogger()
    {
        $log = new Writer(
            new Monolog($this->channel()), $this->app['events']
        );
        $this->configureDailyHandler($log, 'response');
        return $log;
    }
    /**
     * Get the name of the log "channel".
     *
     * @return string
     */
    protected function channel()
    {
        return $this->app->bound('env') ? $this->app->environment() : 'production';
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer $log
     * @param string $base_name
     * @return void
     */
    protected function configureHandler(Writer $log, $base_name)
    {
        $this->{'configure' . ucfirst($this->handler()) . 'Handler'}($log, $base_name);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer $log
     * @param string $base_name
     * @return void
     */
    protected function configureSingleHandler(Writer $log, $base_name)
    {
        $log->useFiles(
            sprintf('%s/logs/%s.log', $this->app->storagePath(), $base_name),
            $this->logLevel()
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer $log
     * @param string $base_name
     * @return void
     */
    protected function configureDailyHandler(Writer $log, $base_name)
    {
        $log->useDailyFiles(
            sprintf('%s/logs/%s/%s.log', $this->app->storagePath(),$base_name,  $base_name),
            $this->maxFiles(),
            $this->logLevel()
        );/**sprintf('%s/logs/%s%s.log.%s', $this->app->storagePath(), $this->getFilePrefix(), $base_name, Carbon::now()->format('Ymd')),useDailyFiles default add time*/
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer $log
     * @param string $base_name
     * @return void
     */
    protected function configureSyslogHandler(Writer $log, $base_name)
    {
        $log->useSyslog($base_name, $this->logLevel());
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Log\Writer $log
     * @param string $base_name
     * @return void
     */
    protected function configureErrorlogHandler(Writer $log, $base_name)
    {
        $log->useErrorLog($this->logLevel());
    }

    /**
     * Get the default log handler.
     *
     * @return string
     */
    protected function handler()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log', 'single');
        }

        return 'single';
    }

    /**
     * Get the log level for the application.
     *
     * @return string
     */
    protected function logLevel()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_level', 'debug');
        }

        return 'debug';
    }

    /**
     * Get the maximum number of log files for the application.
     *
     * @return int
     */
    protected function maxFiles()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_max_files', 5);
        }

        return 0;
    }

    /**
     * get the file prefix
     *
     * @return string
     */
    private function getFilePrefix()
    {
        return php_sapi_name() == 'cli' ? 'cli_' : '';/**return port type between web server and php like that fpm-fcgi、cli*/
    }
}
