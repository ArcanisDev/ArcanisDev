<?php

namespace XF\Http;

use function array_key_exists, count, floatval, in_array, intval, is_array, is_string, strlen, strval;

class Request
{
	/**
	 * @var \XF\InputFilterer
	 */
	protected $filterer;

	protected $input;
	protected $files;
	protected $cookie;
	protected $server;

	protected $skipLogKeys = ['_xfToken'];

	protected $cookiePrefix = '';

	public static $googleIps = [
		'v4' => [
			'35.190.247.0/24',
			'35.191.0.0/16',
			'64.233.160.0/19',
			'66.102.0.0/20',
			'66.249.80.0/20',
			'72.14.192.0/18',
			'74.125.0.0/16',
			'108.177.8.0/21',
			'108.177.96.0/19',
			'130.211.0.0/22',
			'172.217.0.0/19',
			'172.217.32.0/20',
			'172.217.128.0/19',
			'172.217.160.0/20',
			'172.217.192.0/19',
			'172.253.56.0/21',
			'172.253.112.0/20',
			'173.194.0.0/16',
			'209.85.128.0/17',
			'216.58.192.0/19',
			'216.239.32.0/19'
		],
		'v6' => [
			'2a00:1450:4000::/36',
			'2c0f:fb50:4000::/36',
			'2001:4860:4000::/36',
			'2404:6800:4000::/36',
			'2607:f8b0:4000::/36',
			'2800:3f0:4000::/36'
		]
	];

	public static $googleCloudIps = [
		'v4' => [
			'8.34.208.0/23',
			'8.34.210.0/24',
			'8.34.211.0/24',
			'8.34.212.0/22',
			'8.34.216.0/22',
			'8.34.220.0/22',
			'8.35.192.0/21',
			'23.236.48.0/20',
			'23.251.128.0/20',
			'23.251.144.0/20',
			'34.0.0.0/20',
			'34.0.16.0/20',
			'34.0.32.0/20',
			'34.0.48.0/20',
			'34.0.64.0/19',
			'34.0.96.0/19',
			'34.0.128.0/19',
			'34.0.160.0/19',
			'34.0.192.0/19',
			'34.0.224.0/24',
			'34.16.0.0/17',
			'34.16.128.0/17',
			'34.17.0.0/16',
			'34.18.0.0/16',
			'34.19.0.0/17',
			'34.19.128.0/17',
			'34.20.0.0/17',
			'34.20.128.0/17',
			'34.21.0.0/17',
			'34.21.128.0/17',
			'34.22.0.0/19',
			'34.22.32.0/19',
			'34.22.64.0/19',
			'34.22.96.0/20',
			'34.22.112.0/20',
			'34.22.128.0/17',
			'34.23.0.0/16',
			'34.24.0.0/15',
			'34.26.0.0/16',
			'34.27.0.0/16',
			'34.28.0.0/14',
			'34.32.128.0/17',
			'34.33.0.0/16',
			'34.34.0.0/17',
			'34.36.0.0/16',
			'34.64.32.0/19',
			'34.64.64.0/22',
			'34.64.68.0/22',
			'34.64.72.0/21',
			'34.64.80.0/20',
			'34.64.96.0/19',
			'34.64.128.0/22',
			'34.64.132.0/22',
			'34.64.136.0/21',
			'34.64.144.0/20',
			'34.64.160.0/19',
			'34.64.192.0/18',
			'34.65.0.0/16',
			'34.66.0.0/15',
			'34.68.0.0/14',
			'34.72.0.0/16',
			'34.73.0.0/16',
			'34.74.0.0/15',
			'34.76.0.0/14',
			'34.80.0.0/15',
			'34.82.0.0/15',
			'34.84.0.0/16',
			'34.85.0.0/17',
			'34.85.128.0/17',
			'34.86.0.0/16',
			'34.87.0.0/17',
			'34.87.128.0/18',
			'34.87.192.0/18',
			'34.88.0.0/16',
			'34.89.0.0/17',
			'34.89.128.0/17',
			'34.90.0.0/15',
			'34.92.0.0/16',
			'34.93.0.0/16',
			'34.94.0.0/16',
			'34.95.0.0/18',
			'34.95.64.0/18',
			'34.95.128.0/17',
			'34.96.64.0/18',
			'34.96.128.0/17',
			'34.97.0.0/16',
			'34.98.64.0/18',
			'34.98.128.0/21',
			'34.100.128.0/17',
			'34.101.18.0/24',
			'34.101.20.0/22',
			'34.101.24.0/22',
			'34.101.32.0/19',
			'34.101.64.0/18',
			'34.101.128.0/17',
			'34.102.0.0/17',
			'34.102.128.0/17',
			'34.104.27.0/24',
			'34.104.49.0/24',
			'34.104.50.0/23',
			'34.104.52.0/24',
			'34.104.56.0/23',
			'34.104.58.0/23',
			'34.104.60.0/23',
			'34.104.62.0/23',
			'34.104.64.0/21',
			'34.104.72.0/22',
			'34.104.76.0/22',
			'34.104.80.0/21',
			'34.104.88.0/21',
			'34.104.96.0/21',
			'34.104.104.0/23',
			'34.104.106.0/23',
			'34.104.108.0/23',
			'34.104.110.0/23',
			'34.104.112.0/23',
			'34.104.114.0/23',
			'34.104.116.0/22',
			'34.104.120.0/23',
			'34.104.122.0/23',
			'34.104.124.0/23',
			'34.104.126.0/23',
			'34.104.128.0/17',
			'34.105.0.0/17',
			'34.105.128.0/17',
			'34.106.0.0/16',
			'34.107.0.0/17',
			'34.107.128.0/17',
			'34.108.0.0/16',
			'34.110.128.0/17',
			'34.111.0.0/16',
			'34.116.0.0/21',
			'34.116.64.0/18',
			'34.116.128.0/17',
			'34.117.0.0/16',
			'34.118.0.0/17',
			'34.118.128.0/18',
			'34.118.192.0/21',
			'34.118.200.0/21',
			'34.118.240.0/22',
			'34.118.244.0/22',
			'34.118.248.0/23',
			'34.118.250.0/23',
			'34.118.252.0/23',
			'34.118.254.0/23',
			'34.120.0.0/16',
			'34.121.0.0/16',
			'34.122.0.0/15',
			'34.124.0.0/21',
			'34.124.8.0/22',
			'34.124.12.0/22',
			'34.124.16.0/21',
			'34.124.24.0/21',
			'34.124.32.0/21',
			'34.124.40.0/23',
			'34.124.42.0/23',
			'34.124.44.0/23',
			'34.124.46.0/23',
			'34.124.48.0/23',
			'34.124.50.0/23',
			'34.124.52.0/22',
			'34.124.56.0/23',
			'34.124.58.0/23',
			'34.124.60.0/23',
			'34.124.62.0/23',
			'34.124.112.0/20',
			'34.124.128.0/17',
			'34.125.0.0/16',
			'34.126.64.0/18',
			'34.126.128.0/18',
			'34.126.192.0/20',
			'34.126.208.0/20',
			'34.127.0.0/17',
			'34.127.177.0/24',
			'34.127.178.0/23',
			'34.127.180.0/24',
			'34.127.184.0/23',
			'34.127.186.0/23',
			'34.127.188.0/23',
			'34.127.190.0/23',
			'34.128.32.0/22',
			'34.128.64.0/18',
			'34.128.128.0/18',
			'34.129.0.0/16',
			'34.130.0.0/16',
			'34.131.0.0/16',
			'34.132.0.0/14',
			'34.136.0.0/16',
			'34.137.0.0/16',
			'34.138.0.0/15',
			'34.140.0.0/16',
			'34.141.0.0/17',
			'34.141.128.0/17',
			'34.142.0.0/17',
			'34.142.128.0/17',
			'34.143.128.0/17',
			'34.144.192.0/18',
			'34.145.0.0/17',
			'34.145.128.0/17',
			'34.146.0.0/16',
			'34.147.0.0/17',
			'34.147.128.0/17',
			'34.148.0.0/16',
			'34.149.0.0/16',
			'34.150.0.0/17',
			'34.150.128.0/17',
			'34.151.0.0/18',
			'34.151.64.0/18',
			'34.151.128.0/18',
			'34.151.192.0/18',
			'34.152.0.0/18',
			'34.152.64.0/22',
			'34.152.68.0/24',
			'34.152.69.0/24',
			'34.152.72.0/21',
			'34.154.0.0/16',
			'34.155.0.0/16',
			'34.157.0.0/21',
			'34.157.8.0/23',
			'34.157.12.0/22',
			'34.157.16.0/20',
			'34.157.32.0/22',
			'34.157.36.0/22',
			'34.157.40.0/22',
			'34.157.44.0/23',
			'34.157.46.0/23',
			'34.157.48.0/20',
			'34.157.64.0/20',
			'34.157.80.0/23',
			'34.157.82.0/23',
			'34.157.84.0/23',
			'34.157.87.0/24',
			'34.157.88.0/23',
			'34.157.90.0/23',
			'34.157.92.0/22',
			'34.157.96.0/20',
			'34.157.112.0/21',
			'34.157.121.0/24',
			'34.157.124.0/23',
			'34.157.126.0/23',
			'34.157.128.0/21',
			'34.157.136.0/23',
			'34.157.140.0/22',
			'34.157.144.0/20',
			'34.157.160.0/22',
			'34.157.164.0/22',
			'34.157.168.0/22',
			'34.157.172.0/23',
			'34.157.174.0/23',
			'34.157.176.0/20',
			'34.157.192.0/20',
			'34.157.208.0/23',
			'34.157.210.0/23',
			'34.157.212.0/23',
			'34.157.215.0/24',
			'34.157.216.0/23',
			'34.157.220.0/22',
			'34.157.224.0/20',
			'34.157.240.0/21',
			'34.157.249.0/24',
			'34.157.250.0/23',
			'34.157.252.0/23',
			'34.157.254.0/24',
			'34.157.255.0/24',
			'34.159.0.0/16',
			'34.160.0.0/16',
			'34.161.0.0/16',
			'34.162.0.0/16',
			'34.163.0.0/16',
			'34.164.0.0/16',
			'34.165.0.0/16',
			'34.168.0.0/15',
			'34.170.0.0/15',
			'34.172.0.0/15',
			'34.174.0.0/16',
			'34.175.0.0/16',
			'34.176.0.0/16',
			'34.177.32.0/22',
			'34.177.40.0/21',
			'34.177.52.0/22',
			'35.184.0.0/16',
			'35.185.0.0/17',
			'35.185.128.0/19',
			'35.185.160.0/20',
			'35.185.176.0/20',
			'35.185.192.0/18',
			'35.186.0.0/17',
			'35.186.128.0/20',
			'35.186.144.0/20',
			'35.186.160.0/19',
			'35.186.192.0/18',
			'35.187.0.0/17',
			'35.187.144.0/20',
			'35.187.160.0/19',
			'35.187.192.0/19',
			'35.187.224.0/19',
			'35.188.0.0/17',
			'35.188.128.0/18',
			'35.188.192.0/19',
			'35.188.224.0/19',
			'35.189.0.0/18',
			'35.189.64.0/18',
			'35.189.128.0/19',
			'35.189.160.0/19',
			'35.189.192.0/18',
			'35.190.0.0/18',
			'35.190.64.0/19',
			'35.190.112.0/20',
			'35.190.128.0/18',
			'35.190.192.0/19',
			'35.190.224.0/20',
			'35.192.0.0/15',
			'35.194.0.0/18',
			'35.194.64.0/19',
			'35.194.96.0/19',
			'35.194.128.0/17',
			'35.195.0.0/16',
			'35.196.0.0/16',
			'35.197.0.0/17',
			'35.197.128.0/19',
			'35.197.160.0/19',
			'35.197.192.0/18',
			'35.198.0.0/18',
			'35.198.64.0/18',
			'35.198.128.0/18',
			'35.198.192.0/18',
			'35.199.0.0/18',
			'35.199.64.0/18',
			'35.199.144.0/20',
			'35.199.160.0/19',
			'35.200.0.0/17',
			'35.200.128.0/17',
			'35.201.0.0/19',
			'35.201.41.0/24',
			'35.201.64.0/18',
			'35.201.128.0/17',
			'35.202.0.0/16',
			'35.203.0.0/17',
			'35.203.128.0/18',
			'35.203.210.0/23',
			'35.203.212.0/22',
			'35.203.216.0/22',
			'35.203.232.0/21',
			'35.204.0.0/16',
			'35.205.0.0/16',
			'35.206.10.0/23',
			'35.206.32.0/19',
			'35.206.64.0/18',
			'35.206.128.0/18',
			'35.206.192.0/18',
			'35.207.0.0/18',
			'35.207.64.0/18',
			'35.207.128.0/18',
			'35.207.192.0/18',
			'35.208.0.0/15',
			'35.210.0.0/16',
			'35.211.0.0/16',
			'35.212.0.0/17',
			'35.212.128.0/17',
			'35.213.0.0/17',
			'35.213.128.0/18',
			'35.213.192.0/18',
			'35.214.0.0/17',
			'35.214.128.0/17',
			'35.215.0.0/18',
			'35.215.64.0/18',
			'35.215.128.0/18',
			'35.215.192.0/18',
			'35.216.0.0/17',
			'35.216.128.0/17',
			'35.217.0.0/18',
			'35.217.64.0/18',
			'35.217.128.0/17',
			'35.219.0.0/17',
			'35.219.128.0/18',
			'35.219.224.0/19',
			'35.220.0.0/20',
			'35.220.16.0/23',
			'35.220.18.0/23',
			'35.220.20.0/22',
			'35.220.24.0/23',
			'35.220.26.0/24',
			'35.220.27.0/24',
			'35.220.31.0/24',
			'35.220.32.0/21',
			'35.220.40.0/24',
			'35.220.41.0/24',
			'35.220.42.0/24',
			'35.220.43.0/24',
			'35.220.44.0/24',
			'35.220.45.0/24',
			'35.220.46.0/24',
			'35.220.47.0/24',
			'35.220.48.0/21',
			'35.220.56.0/22',
			'35.220.60.0/22',
			'35.220.64.0/19',
			'35.220.96.0/19',
			'35.220.128.0/17',
			'35.221.0.0/18',
			'35.221.64.0/18',
			'35.221.128.0/17',
			'35.222.0.0/15',
			'35.224.0.0/15',
			'35.226.0.0/16',
			'35.227.0.0/17',
			'35.227.128.0/18',
			'35.227.192.0/18',
			'35.228.0.0/16',
			'35.229.16.0/20',
			'35.229.32.0/19',
			'35.229.64.0/18',
			'35.229.128.0/17',
			'35.230.0.0/17',
			'35.230.128.0/19',
			'35.230.160.0/19',
			'35.230.240.0/20',
			'35.231.0.0/16',
			'35.232.0.0/16',
			'35.233.0.0/17',
			'35.233.128.0/17',
			'35.234.0.0/18',
			'35.234.64.0/18',
			'35.234.128.0/19',
			'35.234.160.0/20',
			'35.234.176.0/20',
			'35.234.192.0/20',
			'35.234.208.0/20',
			'35.234.224.0/20',
			'35.234.240.0/20',
			'35.235.0.0/20',
			'35.235.16.0/20',
			'35.235.32.0/20',
			'35.235.48.0/20',
			'35.235.64.0/18',
			'35.235.216.0/21',
			'35.236.0.0/17',
			'35.236.128.0/18',
			'35.236.192.0/18',
			'35.237.0.0/16',
			'35.238.0.0/15',
			'35.240.0.0/17',
			'35.240.128.0/17',
			'35.241.0.0/18',
			'35.241.64.0/18',
			'35.241.128.0/17',
			'35.242.0.0/20',
			'35.242.16.0/23',
			'35.242.18.0/23',
			'35.242.20.0/22',
			'35.242.24.0/23',
			'35.242.26.0/24',
			'35.242.27.0/24',
			'35.242.31.0/24',
			'35.242.32.0/21',
			'35.242.40.0/24',
			'35.242.41.0/24',
			'35.242.42.0/24',
			'35.242.43.0/24',
			'35.242.44.0/24',
			'35.242.45.0/24',
			'35.242.46.0/24',
			'35.242.47.0/24',
			'35.242.48.0/21',
			'35.242.56.0/22',
			'35.242.60.0/22',
			'35.242.64.0/19',
			'35.242.96.0/19',
			'35.242.128.0/18',
			'35.242.192.0/18',
			'35.243.0.0/21',
			'35.243.8.0/21',
			'35.243.32.0/21',
			'35.243.40.0/21',
			'35.243.56.0/21',
			'35.243.64.0/18',
			'35.243.128.0/17',
			'35.244.0.0/18',
			'35.244.64.0/18',
			'35.244.128.0/17',
			'35.245.0.0/16',
			'35.246.0.0/17',
			'35.246.128.0/17',
			'35.247.0.0/17',
			'35.247.128.0/18',
			'35.247.192.0/18',
			'104.154.16.0/20',
			'104.154.32.0/19',
			'104.154.64.0/19',
			'104.154.96.0/20',
			'104.154.113.0/24',
			'104.154.114.0/23',
			'104.154.116.0/22',
			'104.154.120.0/23',
			'104.154.128.0/17',
			'104.155.0.0/17',
			'104.155.128.0/18',
			'104.155.192.0/19',
			'104.155.224.0/20',
			'104.196.0.0/18',
			'104.196.65.0/24',
			'104.196.66.0/23',
			'104.196.68.0/22',
			'104.196.96.0/19',
			'104.196.128.0/18',
			'104.196.192.0/19',
			'104.196.224.0/19',
			'104.197.0.0/16',
			'104.198.0.0/20',
			'104.198.16.0/20',
			'104.198.32.0/19',
			'104.198.64.0/20',
			'104.198.80.0/20',
			'104.198.96.0/20',
			'104.198.112.0/20',
			'104.198.128.0/17',
			'104.199.0.0/18',
			'104.199.66.0/23',
			'104.199.68.0/22',
			'104.199.72.0/21',
			'104.199.80.0/20',
			'104.199.96.0/20',
			'104.199.112.0/20',
			'104.199.128.0/18',
			'104.199.192.0/19',
			'104.199.224.0/20',
			'104.199.242.0/23',
			'104.199.244.0/22',
			'104.199.248.0/21',
			'107.167.160.0/20',
			'107.167.176.0/20',
			'107.178.208.0/20',
			'107.178.240.0/20',
			'108.59.80.0/21',
			'108.59.88.0/21',
			'130.211.4.0/22',
			'130.211.8.0/21',
			'130.211.16.0/20',
			'130.211.32.0/20',
			'130.211.48.0/20',
			'130.211.64.0/19',
			'130.211.96.0/20',
			'130.211.112.0/20',
			'130.211.128.0/18',
			'130.211.192.0/19',
			'130.211.224.0/20',
			'130.211.240.0/20',
			'146.148.2.0/23',
			'146.148.4.0/22',
			'146.148.8.0/21',
			'146.148.16.0/20',
			'146.148.32.0/19',
			'146.148.64.0/19',
			'146.148.96.0/20',
			'146.148.112.0/20',
			'162.216.148.0/22',
			'162.222.176.0/21',
			'173.255.112.0/21',
			'173.255.120.0/21',
			'192.158.28.0/22',
			'199.192.115.0/24',
			'199.223.232.0/22',
			'199.223.236.0/24'
		],
		'v6' => [
			'2600:1900:40a0::/44',
			'2600:1900:40b0::/44',
			'2600:1900:40c0::/44',
			'2600:1900:40d0::/44',
			'2600:1900:40e0::/44',
			'2600:1900:40f0::/44',
			'2600:1900:41a0::/44',
			'2600:1900:41b0::/44',
			'2600:1900:41c0::/44',
			'2600:1900:41d0::/44',
			'2600:1900:41e0::/44',
			'2600:1900:4000::/44',
			'2600:1900:4010::/44',
			'2600:1900:4020::/44',
			'2600:1900:4030::/44',
			'2600:1900:4040::/44',
			'2600:1900:4050::/44',
			'2600:1900:4060::/44',
			'2600:1900:4070::/44',
			'2600:1900:4080::/44',
			'2600:1900:4090::/44',
			'2600:1900:4120::/44',
			'2600:1900:4140::/44',
			'2600:1900:4150::/44',
			'2600:1900:4160::/44',
			'2600:1900:4170::/44',
			'2600:1900:4180::/44',
			'2600:1901:81b0::/44',
			'2600:1901:81c0::/44',
			'2600:1901:4010::/44',
			'2600:1901:8100::/44',
			'2600:1901:8110::/44',
			'2600:1901:8120::/44',
			'2600:1901:8130::/44',
			'2600:1901:8140::/44',
			'2600:1901:8150::/44',
			'2600:1901:8160::/44',
			'2600:1901:8170::/44',
			'2600:1901:8180::/44',
			'2600:1901::/48'
		],
	];

	public static $cloudFlareIps = [
		'v4' => [
			'103.21.244.0/22',
			'103.22.200.0/22',
			'103.31.4.0/22',
			'104.16.0.0/13',
			'104.24.0.0/14',
			'108.162.192.0/18',
			'131.0.72.0/22',
			'141.101.64.0/18',
			'162.158.0.0/15',
			'172.64.0.0/13',
			'173.245.48.0/20',
			'188.114.96.0/20',
			'190.93.240.0/20',
			'197.234.240.0/22',
			'198.41.128.0/17'
		],
		'v6' => [
			'2a06:98c0::/29',
			'2c0f:f248::/32',
			'2400:cb00::/32',
			'2405:8100::/32',
			'2405:b500::/32',
			'2606:4700::/32',
			'2803:f800::/32'
		]
	];

	protected $remoteIp = null;

	protected $robotName;

	protected $fromSearch;

	protected static $customMethodPhpInput = null;

	public function __construct(\XF\InputFilterer $filterer,
		array $input = null, array $files = null, array $cookie = null, array $server = null
	)
	{
		$this->filterer = $filterer;

		if ($input === null)
		{
			if (self::$customMethodPhpInput === null)
			{
				self::$customMethodPhpInput = $this->convertCustomMethodPhpInput();
			}

			$input = self::$customMethodPhpInput + $_POST + $_GET;
		}
		if ($files === null)
		{
			$files = $_FILES;
		}
		if ($cookie === null)
		{
			$cookie = $_COOKIE;
		}
		if ($server === null)
		{
			$server = $_SERVER;
		}

		$this->input = $input;
		$this->files = $files;
		$this->cookie = $cookie;
		$this->server = $server;
	}

	protected function convertCustomMethodPhpInput()
	{
		if (!empty($_SERVER['REQUEST_METHOD'])
			&& in_array(strtoupper($_SERVER['REQUEST_METHOD']), ['PUT', 'PATCH', 'DELETE'])
			&& !empty($_SERVER['CONTENT_TYPE'])
			&& $_SERVER['CONTENT_TYPE'] === 'application/x-www-form-urlencoded'
		)
		{
			$rawInput = @file_get_contents("php://input");
			if ($rawInput)
			{
				parse_str($rawInput, $extra);
				if (is_array($extra))
				{
					return $extra;
				}
			}
		}

		return [];
	}

	public function setCookiePrefix($prefix)
	{
		$this->cookiePrefix = $prefix;
	}

	public function getCookiePrefix()
	{
		return $this->cookiePrefix;
	}

	public function get($key, $fallback = false)
	{
		$subParts = explode('.', $key);
		$key = array_shift($subParts);

		if (array_key_exists($key, $this->input))
		{
			$value = $this->input[$key];
		}
		else
		{
			return $fallback;
		}

		return $this->getSubValue($value, $subParts, $fallback);
	}

	public function exists($key)
	{
		$subParts = explode('.', $key);
		$key = array_shift($subParts);

		if (array_key_exists($key, $this->input))
		{
			$value = $this->input[$key];
		}
		else
		{
			return false;
		}

		while ($subParts)
		{
			if (!is_array($value))
			{
				return false;
			}

			$key = array_shift($subParts);
			if (array_key_exists($key, $value))
			{
				$value = $value[$key];
			}
			else
			{
				return false;
			}
		}

		return true;
	}

	public function getUser($key, $fallback = false)
	{
		return $this->get($key, $fallback);
	}

	protected function getSubValue($value, array $subParts, $fallback)
	{
		while ($subParts)
		{
			if (!is_array($value))
			{
				return $fallback;
			}

			$key = array_shift($subParts);
			if (array_key_exists($key, $value))
			{
				$value = $value[$key];
			}
			else
			{
				return $fallback;
			}
		}

		return $value;
	}

	public function filter($key, $type = null, $default = null)
	{
		if (is_array($key) && $type === null)
		{
			$output = [];
			foreach ($key AS $name => $value)
			{
				if (is_array($value))
				{
					$array = $this->get($name);
					if (!is_array($array))
					{
						$array = [];
					}
					$output[$name] = $this->filterer->filterArray($array, $value);
				}
				else
				{
					$output[$name] = $this->filter($name, $value);
				}
			}

			return $output;
		}
		else
		{
			$value = $this->get($key, $default);

			if (is_string($type) && $type[0] == '?')
			{
				if ($value === null)
				{
					return null;
				}

				$type = substr($type, 1);
			}

			if (is_array($type))
			{
				if (!is_array($value))
				{
					$value = [];
				}

				return $this->filterer->filterArray($value, $type);
			}
			else
			{
				return $this->filterer->filter($value, $type);
			}
		}
	}

	/**
	 * @param $key string Input key to set - either 'keyName' or 'arrayName.subArrayName.keyName' etc.
	 * @param $value
	 */
	public function set($key, $value)
	{
		$parts = explode('.', $key);

		$var =& $this->input;
		while ($part = array_shift($parts))
		{
			$var =& $var[$part];
		}

		$var = $value;
	}

	public function getInput()
	{
		return $this->input;
	}

	public function getInputForLogs()
	{
		return $this->filterForLog($this->input);
	}

	public function filterForLog(array $data)
	{
		$skip = array_fill_keys($this->skipLogKeys, true);

		$filter = function(array $d) use ($skip, &$filter)
		{
			$output = [];
			foreach ($d AS $k => $v)
			{
				if (isset($skip[$k]) || strpos($k, 'password') !== false)
				{
					$output[$k] = '********';
				}
				else if (is_array($v))
				{
					$output[$k] = $filter($v);
				}
				else
				{
					$output[$k] = $v;
				}
			}

			return $output;
		};

		return $filter($data);
	}

	public function skipKeyForLogging($key)
	{
		$this->skipLogKeys[] = $key;
	}

	public function fileExists($key)
	{
		return isset($this->files[$key]['name']);
	}

	/**
	 * @param string $key
	 * @param bool $multiple If true, returns an array of uploads for this key
	 * @param bool $skipErrors If true, uploads with errors will not be returned
	 *
	 * @return Upload|Upload[]
	 */
	public function getFile($key, $multiple = false, $skipErrors = true)
	{
		if (!$this->fileExists($key))
		{
			return ($multiple ? [] : null);
		}

		if (is_array($this->files[$key]['name']))
		{
			// multiple uploads
			$files = [];
			foreach (array_keys($this->files[$key]['name']) AS $idx)
			{
				$files[$idx] = [
					'name' => $this->files[$key]['name'][$idx],
					'type' => $this->files[$key]['type'][$idx],
					'size' => $this->files[$key]['size'][$idx],
					'tmp_name' => $this->files[$key]['tmp_name'][$idx],
					'error' => $this->files[$key]['error'][$idx],
				];
			}
		}
		else
		{
			// single upload
			$files = [$this->files[$key]];
		}

		$output = [];

		$imageI = 1;
		$imageBase = 'img-' . gmdate('Y-m-d-H-i-s') . '-';

		foreach ($files AS $idx => $file)
		{
			if ($file['error'] == UPLOAD_ERR_NO_FILE || ($skipErrors && $file['error']))
			{
				// didn't upload a file or has errors - just ignore
				continue;
			}

			// this handles files uploaded via JS that don't have a proper filename
			if ($file['name'] == 'blob' && preg_match('#^image/(pjpeg|jpeg|gif|png)$#', $file['type'], $match))
			{
				switch ($match[1])
				{
					case 'jpeg':
					case 'pjpeg':
						$type = 'jpg';
						break;

					default:
						$type = $match[1];
				}

				$file['name'] = $imageBase . $imageI . '.' . $type;
				$imageI++;
			}

			$class = \XF::extendClass('XF\Http\Upload');
			$output[$idx] = new $class($file['tmp_name'], $file['name'], $file['error']);
		}

		if ($multiple)
		{
			return $output;
		}
		else
		{
			return reset($output);
		}
	}

	public function getCookie($key, $fallback = false)
	{
		$cookie = $this->getCookieRaw($this->cookiePrefix . $key, $fallback);
		if (is_array($cookie) && !is_array($fallback))
		{
			$cookie = $fallback;
		}

		return $cookie;
	}

	public function getCookieArray($key, array $fallback = [])
	{
		$cookie = $this->getCookieRaw($this->cookiePrefix . $key, $fallback);
		if (!is_array($cookie))
		{
			$cookie = $fallback;
		}

		return $cookie;
	}

	public function getCookies($prefixFiltered = true)
	{
		if (!$prefixFiltered)
		{
			return $this->cookie;
		}

		$output = [];
		$prefixLength = strlen($this->cookiePrefix);

		foreach ($this->cookie AS $cookie => $value)
		{
			if (substr($cookie, 0, $prefixLength) == $this->cookiePrefix)
			{
				$cookie = substr($cookie, $prefixLength);
				if (is_string($cookie) && strlen($cookie))
				{
					$output[$cookie] = $value;
				}
			}
		}

		return $output;
	}

	public function getCookieRaw($key, $fallback = false)
	{
		if (array_key_exists($key, $this->cookie))
		{
			return $this->cookie[$key];
		}
		else
		{
			return $fallback;
		}
	}

	public function getInputRaw($fallback = '')
	{
		$input = file_get_contents('php://input');
		return ($input ?: $fallback);
	}

	public function getIp($allowProxied = false)
	{
		if ($allowProxied && $ip = $this->getServer('HTTP_CLIENT_IP'))
		{
			list($ip) = explode(',', $ip);
			return $this->getFilteredIp($ip);
		}
		else if ($allowProxied && $ip = $this->getServer('HTTP_X_FORWARDED_FOR'))
		{
			list($ip) = explode(',', $ip);
			return $this->getFilteredIp($ip);
		}

		if ($this->remoteIp === null)
		{
			$ip = $this->getTrustedRealIp($this->getServer('REMOTE_ADDR'));
			$this->remoteIp = $this->getFilteredIp($ip);
		}

		return $this->remoteIp;
	}

	public function getAllIps()
	{
		$proxied = $this->getIp(true);
		$unproxied = $this->getIp(false);

		if ($proxied === $unproxied)
		{
			return $unproxied;
		}

		$ips = preg_split('/,\s*/', $proxied);
		$ips[] = $unproxied;

		return array_unique($ips);
	}

	protected function getTrustedRealIp($ip)
	{
		$via = $this->getServer('HTTP_VIA');
		if ($via && strpos(strtolower($via), 'chrome-compression-proxy'))
		{
			// may have Google Data Saver enabled
			$realIps = $this->getServer('HTTP_X_FORWARDED_FOR');
			if ($realIps)
			{
				$realIps = explode(',', $realIps);
				$realIp = end($realIps);
				$realIp = trim($realIp);

				if ($this->ipMatchesRanges($ip, self::$googleIps))
				{
					if (!$this->ipMatchesRanges($ip, self::$googleCloudIps))
					{
						// if the IP comes from a known Google IP, but NOT listed as a known Google Cloud IP
						// then we can trust that they put the client IP in X-Forwarded-For
						// (They should have appended it to the end.)
						return $realIp;
					}
				}
			}
		}

		$cfIp = $this->getServer('HTTP_CF_CONNECTING_IP');
		if ($cfIp && $cfIp !== $ip)
		{
			if ($this->ipMatchesRanges($ip, self::$cloudFlareIps))
			{
				// connection from known CloudFlare IP, real IP in their header
				return $cfIp;
			}
		}

		return $ip;
	}

	protected function ipMatchesRanges($ip, array $ranges)
	{
		$ip = \XF\Util\Ip::convertIpStringToBinary($ip);
		if ($ip === false)
		{
			return false;
		}

		$type = strlen($ip) == 4 ? 'v4' : 'v6';

		if (empty($ranges[$type]))
		{
			return false;
		}

		foreach ($ranges[$type] AS $range)
		{
			if (is_string($range))
			{
				$range = explode('/', $range);
			}

			$rangeIp = \XF\Util\Ip::convertIpStringToBinary($range[0]);
			$cidr = intval($range[1]);

			if (\XF\Util\Ip::ipMatchesCidrRange($ip, $rangeIp, $cidr))
			{
				return true;
			}
		}

		return false;
	}

	protected function getFilteredIp($ip)
	{
		$ip = trim($ip);

		if (preg_match('#:(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$#', $ip, $match))
		{
			// embedded IPv4
			$long = ip2long($match[1]);
			if (!$long)
			{
				return $ip;
			}

			return $match[1];
		}

		return $ip;
	}

	public function getUserAgent()
	{
		return $this->getServer('HTTP_USER_AGENT');
	}

	public function getBrowser(): array
	{
		$ua = strtolower($this->getUserAgent());
		$match = [];
		$browser = [];

		preg_match('/trident\/.*rv:([0-9.]+)/', $ua, $match);
		if ($match)
		{
			$browser = [
				'browser' => 'msie',
				'version' => floatval($match[1])
			];
		}
		else
		{
			if (
				!preg_match('/(msie)[ \/]([0-9\.]+)/', $ua, $match) &&
				!preg_match('/(edge)[ \/]([0-9\.]+)/', $ua, $match) &&
				!preg_match('/(chrome)[ \/]([0-9\.]+)/', $ua, $match) &&
				!preg_match('/(webkit)[ \/]([0-9\.]+)/', $ua, $match) &&
				!preg_match('/(opera)(?:.*version|)[ \/]([0-9\.]+)/', $ua, $match) &&
				!(
					strpos($ua, 'compatible') === false &&
					preg_match('/(mozilla)(?:.*? rv:([0-9\.]+)|)/', $ua, $match)
				)
			)
			{
				$match = [];
			}

			if ($match && $match[1] == 'webkit' && strpos($ua, 'safari') !== false)
			{
				preg_match('/version[ \/]([0-9\.]+)/', $ua, $safariMatch);
				if ($safariMatch)
				{
					$match = [$match[0], 'safari', $safariMatch[1]];
				}
			}

			$browser = [
				'browser' => $match[1] ?? '',
				'version' => isset($match[2]) ? floatval($match[2]) : 0.0
			];
		}

		$os = '';
		$osVersion = null;
		$osMatch = [];

		if (preg_match('/(ipad|iphone|ipod)/', $ua))
		{
			$os = 'ios';
			preg_match('/os ([0-9_]+)/', $ua, $osMatch);
			if ($osMatch)
			{
				$osVersion = floatval(str_replace('_', '.', $osMatch[1]));
			}
		}
		else if (preg_match('/android[ \/]([0-9\.]+)/', $ua, $osMatch))
		{
			$os = 'android';
			$osVersion = floatval($osMatch[1]);
		}
		else if (preg_match('/windows /', $ua))
		{
			$os = 'windows';
		}
		else if (preg_match('/linux/', $ua))
		{
			$os = 'linux';
		}
		else if (preg_match('/mac os/', $ua))
		{
			$os = 'mac';
		}

		$browser['os'] = $os;
		$browser['osVersion'] = $osVersion;

		return $browser;
	}

	public function getRobotName()
	{
		if ($this->robotName === null)
		{
			$userAgent = $this->getUserAgent();
			if ($userAgent)
			{
				$this->robotName = \XF::app()->data('XF:Robot')->userAgentMatchesRobot($userAgent);
			}
			else
			{
				$this->robotName = '';
			}
		}

		return $this->robotName;
	}

	/**
	 * @return string
	 */
	public function getFromSearch()
	{
		if ($this->fromSearch === null)
		{
			$this->populateFromSearch();
		}

		return $this->fromSearch;
	}

	public function populateFromSearch(Response $persistResponse = null)
	{
		$fromSearch = $this->getCookie('from_search');
		if (!is_string($fromSearch))
		{
			$referrer = $this->getReferrer();
			if ($referrer)
			{
				$fromSearch = \XF::app()->data('XF:Search')->urlMatchesSearchDomain($referrer);
				$cookieConsent = \XF::app()->cookieConsent();
				if ($persistResponse && $fromSearch && $cookieConsent->isCookieConsented('from_search'))
				{
					$persistResponse->setCookie('from_search', $fromSearch, 0, null, false);
				}
			}
			else
			{
				$fromSearch = '';
			}
		}

		$this->fromSearch = $fromSearch;

		return $this->fromSearch;
	}

	public function getReferrer()
	{
		$referrer = $this->getServer('HTTP_REFERER');

		if ($referrer && strpos($referrer, 'service_worker.js') !== false)
		{
			// Safari might put the service worker in as the referrer, which is
			// never correct
			$referrer = false;
		}

		return $referrer;
	}

	public function getServer($key, $fallback = false)
	{
		if (array_key_exists($key, $this->server))
		{
			return $this->server[$key];
		}
		else
		{
			return $fallback;
		}
	}

	public function getRequestMethod()
	{
		return strtolower($this->getServer('REQUEST_METHOD'));
	}

	public function getApiKey()
	{
		return trim($this->getServer('HTTP_XF_API_KEY', ''));
	}

	public function getApiUser()
	{
		return intval($this->getServer('HTTP_XF_API_USER', 0));
	}

	public function isGet()
	{
		return ($this->getRequestMethod() === 'get');
	}

	public function isHead()
	{
		return ($this->getRequestMethod() === 'head');
	}

	public function isPost()
	{
		return ($this->getRequestMethod() === 'post');
	}

	public function isXhr()
	{
		return ($this->getServer('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
	}

	public function isSecure()
	{
		return (
			$this->getServer('REQUEST_SCHEME') === 'https'
			|| $this->getServer('HTTP_X_FORWARDED_PROTO') === 'https'
			|| $this->getServer('HTTPS') === 'on'
			|| $this->getServer('SERVER_PORT') == 443
		);
	}

	public function isPrefetch()
	{
		return (
			$this->getServer('HTTP_X_MOZ') === 'prefetch'
			|| $this->getServer('HTTP_X_PURPOSE') === 'prefetch'
			|| $this->getServer('HTTP_PURPOSE') === 'prefetch'
		);
	}

	/**
	 * Returns true if the host name (either provided or the current one) is a
	 * locally/loopback served page. Note that this should not be used in security-related
	 * constructs as it may rely on an unverified, user-provided value.
	 *
	 * This function's primary use is in conjunction with isSecure() checks, to allow access
	 * to certain client functionality that usually requires a secure connection but is allowed
	 * on local/loopback addresses.
	 *
	 * @param string|null $host Current host if not specified
	 *
	 * @return bool
	 */
	public function isHostLocal($host = null)
	{
		if ($host === null)
		{
			$host = $this->getHost();
		}

		return (
			$host == 'localhost'
			|| $host == '[::1]'
			|| substr($host, -10) === '.localhost'
			|| preg_match('#^127\.\d+\.\d+\.\d+$#', $host)
		);
	}

	public function getProtocol()
	{
		return $this->isSecure() ? 'https' : 'http';
	}

	public function getBaseUrl()
	{
		$baseUrl = $this->getServer('SCRIPT_NAME', '');
		$basePath = dirname($baseUrl);

		if (strlen($basePath) <= 1)
		{
			// Looks to be at the root, so trust that.
			return $baseUrl;
		}

		$requestUri = $this->getRequestUri();
		if (!strlen($requestUri))
		{
			// no request URI, probably not a normal HTTP request - just return the root
			return '/';
		}

		if (strpos($requestUri, $basePath) === 0)
		{
			// We're not at the root but we match the first part of the request URI, so trust that.
			return $baseUrl;
		}

		// Otherwise, the SCRIPT_NAME is wrong and likely has extra stuff prepended. See if we can find the request
		// URI in the base URL. If so, ignore what comes before it.
		$qsPos = strpos($requestUri, '?');
		if ($qsPos !== false)
		{
			$requestUriNoQs = substr($requestUri, 0, $qsPos);
		}
		else
		{
			$requestUriNoQs = $requestUri;
		}

		$requestPos = strpos($baseUrl, $requestUriNoQs);
		if ($requestPos)
		{
			$realBaseUrl = substr($baseUrl, $requestPos);
			if ($realBaseUrl)
			{
				return $realBaseUrl;
			}
		}

		return $baseUrl;
	}

	public function getBasePath()
	{
		$baseUrl = $this->getBaseUrl();

		if (is_string($baseUrl) && strlen($baseUrl))
		{
			$lastSlash = strrpos($baseUrl, '/');
			if ($lastSlash) // intentionally skipping for false and 0
			{
				return substr($baseUrl, 0, $lastSlash);
			}
		}

		return '/';
	}

	public function getFullBasePath()
	{
		return $this->getHostUrl() . $this->getBasePath();
	}

	public function getXfRootPath()
	{
		$basePath = $this->getBasePath();

		$scriptPath = $this->getServer('SCRIPT_FILENAME', '');
		if (!$scriptPath)
		{
			return $basePath;
		}

		$trailingPath = \XF\Util\File::stripRootPathPrefix($scriptPath);
		if (!$trailingPath)
		{
			// stripping the root path failed, so we know the trailing path isn't correct
			return $basePath;
		}

		$trailingPath = dirname($trailingPath);
		if (\XF::$DS !== '/')
		{
			$trailingPath = str_replace(\XF::$DS, '/', $trailingPath);
		}

		if (!$trailingPath || $trailingPath === '/')
		{
			// the script we're running is in the XF root, just use the base path
			return $basePath;
		}
		else if (substr($basePath, -strlen($trailingPath)) === $trailingPath)
		{
			$rootPath = substr($basePath, 0, -strlen($trailingPath));
			if ($rootPath)
			{
				$rootPath = rtrim($rootPath, '/');
			}
			return $rootPath ?: '/';
		}
		else
		{
			return $basePath;
		}
	}

	public function getFullXfRootPath()
	{
		return $this->getHostUrl() . $this->getXfRootPath();
	}

	public function getExtendedUrl($requestUri = null)
	{
		$baseUrl = $this->getBaseUrl();
		$basePath = $this->getBasePath();

		if ($requestUri === null)
		{
			$requestUri = $this->getRequestUri();
		}

		if (strpos($requestUri, $baseUrl) === 0)
		{
			return strval(substr($requestUri, strlen($baseUrl)));
		}
		else if (strpos($requestUri, $basePath) === 0)
		{
			return strval(substr($requestUri, strlen($basePath)));
		}
		else
		{
			return $requestUri;
		}
	}

	public function getRequestUri()
	{
		if ($this->getServer('IIS_WasUrlRewritten') === '1')
		{
			$unencodedUrl = $this->getServer('UNENCODED_URL', '');
			if ($unencodedUrl !== '')
			{
				return $unencodedUrl;
			}
		}

		return $this->getServer('REQUEST_URI', '');
	}

	public function getFullRequestUri()
	{
		return $this->getHostUrl() . $this->getRequestUri();
	}

	public function getHost()
	{
		$host = $this->getServer('HTTP_HOST');
		if (!$host)
		{
			$host = $this->getServer('SERVER_NAME');
			$port = intval($this->getServer('SERVER_PORT'));
			if ($port && $port != 80 && $port != 443)
			{
				$host .= ":$port";
			}
		}

		return $host;
	}

	public function getHostUrl()
	{
		return $this->getProtocol() . '://' . $this->getHost();
	}

	/**
	 * @return string
	 */
	public function getRoutePath()
	{
		$xfRoute = $this->filter('_xfRoute', 'str');
		if ($xfRoute)
		{
			return $xfRoute;
		}
		$routePath = ltrim($this->getExtendedUrl(), '/');
		return $this->getRoutePathInternal($routePath);
	}

	public function getRoutePathFromExtended($extended)
	{
		$routePath = ltrim($extended, '/');
		return $this->getRoutePathInternal($routePath);
	}

	public function getRoutePathFromUrl($url, bool $stripScript = false)
	{
		$url = $this->convertToAbsoluteUri($url);
		$url = str_replace($this->getHostUrl(), '', $url);

		if ($stripScript)
		{
			$url = preg_replace('#^/.*[a-z0-9-_]+\.php\?#i', '?', $url);
		}

		$routePath = ltrim($this->getExtendedUrl($url), '/');

		return $this->getRoutePathInternal($routePath);
	}

	protected function getRoutePathInternal($routePath)
	{
		if (strlen($routePath) == 0)
		{
			return '';
		}

		if ($routePath[0] == '?')
		{
			$routePath = substr($routePath, 1);

			$nextArg = strpos($routePath, '&');
			if ($nextArg !== false)
			{
				$routePath = substr($routePath, 0, $nextArg);
			}

			if (strpos($routePath, '=') !== false)
			{
				return ''; // first bit has a "=" so it's named
			}
		}
		else
		{
			$queryStart = strpos($routePath, '?');
			if ($queryStart !== false)
			{
				$routePath = substr($routePath, 0, $queryStart);
			}
		}

		return strval($routePath);
	}

	/**
	 * @return string[]
	 */
	public function getRequestQueryParams(bool $stripRoute = false): array
	{
		$requestUri = $this->getRequestUri();
		if (strlen($requestUri) === 0)
		{
			return [];
		}

		$queryString = @parse_url($requestUri, PHP_URL_QUERY);
		if (!$queryString)
		{
			return [];
		}

		$queryParams = \XF\Util\Arr::parseQueryString($queryString);

		if ($stripRoute)
		{
			if (reset($queryParams) === '')
			{
				array_shift($queryParams);
			}
		}

		return $queryParams;
	}

	/**
	 * @param string[] $skip
	 *
	 * @return string[]
	 */
	public function getRequestQueryParamsExcept(
		array $skip,
		bool $stripRoute = false
	): array
	{
		$params = $this->getRequestQueryParams($stripRoute);

		foreach ($skip as $name)
		{
			unset($params[$name]);
		}

		return $params;
	}

	public function parseAcceptHeaderValue($headerValue)
	{
		$headerValue = trim($headerValue);
		if (!$headerValue)
		{
			return [];
		}

		$accept = [];

		foreach (explode(',', $headerValue) AS $acceptPart)
		{
			$acceptPart = trim($acceptPart);
			if (!strlen($acceptPart))
			{
				continue;
			}

			$segments = explode(';', $acceptPart);
			$type = trim($segments[0]);
			if (!strlen($type))
			{
				continue;
			}

			unset($segments[0]);

			$options = [];
			foreach ($segments AS $segment)
			{
				$option = explode('=', $segment, 2);
				if (isset($option[1]))
				{
					$options[trim($option[0])] = trim($option[1]);
				}
				else
				{
					$options[trim($option[0])] = true;
				}
			}

			if (isset($options['q']))
			{
				$q = floatval($options['q']);
				$q = max(0, min(1, $q));
				unset($options['q']);
			}
			else
			{
				$q = 1;
			}

			$accept[] = [
				'type' => $type,
				'q' => $q,
				'options' => $options
			];
		}

		usort($accept, function($a, $b)
		{
			if ($a['q'] > $b['q'])
			{
				return -1;
			}
			else if ($a['q'] < $b['q'])
			{
				return 1;
			}

			$aTypeParts = explode('/', $a['type'], 2);
			if (isset($aTypeParts[1]))
			{
				$aType = $aTypeParts[0];
				$aSubType = $aTypeParts[1];
			}
			else
			{
				$aType = $a['type'];
				$aSubType = null;
			}

			$bTypeParts = explode('/', $b['type'], 2);
			if (isset($bTypeParts[1]))
			{
				$bType = $bTypeParts[0];
				$bSubType = $bTypeParts[1];
			}
			else
			{
				$bType = $b['type'];
				$bSubType = null;
			}

			if ($aType !== '*' && $bType === '*')
			{
				return -1;
			}
			else if ($aType === '*' && $bType !== '*')
			{
				return 1;
			}
			else if ($aType !== $bType)
			{
				// main types are different, so no comparison can be done
				return 0;
			}

			// main types are now known to be the same

			if ($aSubType !== null && $bSubType === null)
			{
				return -1;
			}
			else if ($aSubType === null && $bSubType !== null)
			{
				return 1;
			}

			if ($aSubType !== '*' && $bSubType === '*')
			{
				return -1;
			}
			else if ($aSubType === '*' && $bSubType !== '*')
			{
				return 1;
			}

			// sub-types may be different but have equal precedence
			$aOptionCount = count($a['options']);
			$bOptionCount = count($b['options']);

			if ($aOptionCount > $bOptionCount)
			{
				return -1;
			}
			else if ($aOptionCount < $bOptionCount)
			{
				return 1;
			}

			// nothing else we can check, they're tied
			return 0;
		});

		return $accept;
	}

	public function isEmbeddedImageRequest(): bool
	{
		$accept = $this->parseAcceptHeaderValue($this->getServer('HTTP_ACCEPT'));
		if (!$accept)
		{
			return false;
		}

		$haveImageMatch = false;

		foreach ($accept AS $acceptType)
		{
			$mimeType = strtolower($acceptType['type']);

			switch (strtolower($mimeType))
			{
				case 'text/html':
				case 'application/xhtml+xml':
					// we're explicitly asking for HTML, so don't consider as an image request
					return false;
			}

			if ($mimeType === '*/*')
			{
				// general match, don't count as this is almost always present
				continue;
			}

			if (substr($mimeType, 0, 6) !== 'image/')
			{
				// we are accepting something that isn't an image, so don't consider this as an image request
				return false;
			}

			$haveImageMatch = true;
		}

		return $haveImageMatch;
	}

	public function convertToAbsoluteUri($uri, $fullBasePath = null)
	{
		if (!$fullBasePath)
		{
			$fullBasePath = $this->getFullBasePath();
		}

		return \XF::convertToAbsoluteUrl($uri, $fullBasePath);
	}

	public function getInputFilterer()
	{
		return $this->filterer;
	}

	public function getNewArrayFilterer(array $input = [])
	{
		return $this->filterer->getNewArrayFilterer($input);
	}
}