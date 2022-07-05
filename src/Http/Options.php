<?php

namespace JosanBr\GalaxPay\Http;

use GuzzleHttp\RequestOptions;
use JosanBr\GalaxPay\Abstracts\Model;

/**
 * Request Options class
 * 
 * @property bool|array  allow_redirects
 * @property string|array cert
 * @property float connect_timeout
 * @property bool|resource debug
 * @property bool decode_content
 * @property int delay
 * @property bool|integer expect
 * @property array headers
 * @property bool http_errors
 * @property bool|int idn_conversion
 * @property callable on_headers
 * @property callable on_stats
 * @property callable progress
 * @property array|string ssl_key
 * @property bool|string verify
 * @property float timeout
 * @property float read_timeout
 * @property float version
 * @property bool orce_ip_resolve
 * @property int|string client_galax_id
 * @property string id_type
 * 
 * @link http://docs.guzzlephp.org/en/v6/request-options.html
 */
final class Options extends Model
{
    /**
     * @var string[]
     */
    public $fillable = [
        RequestOptions::ALLOW_REDIRECTS,
        RequestOptions::CERT,
        RequestOptions::CONNECT_TIMEOUT,
        RequestOptions::DEBUG,
        RequestOptions::DECODE_CONTENT,
        RequestOptions::DELAY,
        RequestOptions::EXPECT,
        RequestOptions::HEADERS,
        RequestOptions::HTTP_ERRORS,
        RequestOptions::IDN_CONVERSION,
        RequestOptions::ON_HEADERS,
        RequestOptions::ON_STATS,
        RequestOptions::PROGRESS,
        RequestOptions::SSL_KEY,
        RequestOptions::STREAM,
        RequestOptions::VERIFY,
        RequestOptions::TIMEOUT,
        RequestOptions::READ_TIMEOUT,
        RequestOptions::VERSION,
        RequestOptions::FORCE_IP_RESOLVE,
        // Custom
        'client_galax_id',
        'id_type'
    ];

    public function toArray(): array
    {
        return collect($this->jsonSerialize())
            ->except(['client_galax_id', 'id_type'])
            ->reject(function ($item) {
                return is_null($item);
            })->toArray();
    }
}
