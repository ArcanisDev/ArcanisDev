<?php

namespace XF\Repository;

use XF\Mvc\Entity\Repository;
use XF\Util\File;

class EmailDkim extends Repository
{
	public function getDnsRecordName(): string
	{
		return 'xenforo._domainkey';
	}

	public function getDnsRecordValueFromPrivateKey(string $privateKeyFilePath): string
	{
		$publicKey = $this->getPublicKeyFromPrivateKey($privateKeyFilePath);

		return 'v=DKIM1; k=rsa; h=sha256; t=s; p=' . $publicKey;
	}

	public function verifyDnsRecordForDomain(string $domain, string $privateKeyFilePath): bool
	{
		$dnsRecordName = $this->getDnsRecordName();
		$dnsRecord = dns_get_record("$dnsRecordName.$domain", DNS_TXT);

		if (empty($dnsRecord))
		{
			return false;
		}

		$dnsRecord = reset($dnsRecord);

		$correctRecordValue = $this->getDnsRecordValueFromPrivateKey($privateKeyFilePath);

		return $correctRecordValue === $dnsRecord['txt'];
	}

	public function generateAndSaveNewKey(): string
	{
		$key = openssl_pkey_new([
			'digest_alg' => 'sha256',
			'private_key_bits' => 2048,
			'private_key_type' => OPENSSL_KEYTYPE_RSA
		]);

		if (!$key)
		{
			throw new \Exception('Email DKIM: Could not generate keypair');
		}

		openssl_pkey_export($key, $privateKey);

		if (PHP_MAJOR_VERSION < 8)
		{
			openssl_pkey_free($key);
		}

		$keyFileName = 'emailDkim-' . \XF::generateRandomString(10) . '.key';

		$tempFile = File::getTempFile();
		File::writeFile($tempFile, $privateKey);
		File::copyFileToAbstractedPath($tempFile, $this->getAbstractedKeyPath($keyFileName));

		return $keyFileName;
	}

	protected function getPublicKeyFromPrivateKey(string $privateKeyFilePath): string
	{
		try
		{
			$path = $this->getAbstractedKeyPath($privateKeyFilePath);
			$keyFile = \XF::fs()->read($path);
		}
		catch (\Exception $e)
		{
			throw new \RuntimeException("Email DKIM: Key not found at $path");
		}

		$key = openssl_pkey_get_private($keyFile);
		if (!$key)
		{
			throw new \Exception('Email DKIM: Unable to get private key from specified key file');
		}

		$keyDetails = openssl_pkey_get_details($key);
		if (!$keyDetails)
		{
			throw new \Exception('Email DKIM: Could not get key details from key resource');
		}

		$publicKey = $keyDetails['key'];
		$publicKey = preg_replace('/^-+.*?-+$/m', '', $publicKey);
		$publicKey = str_replace(["\r", "\n"], '', $publicKey);

		return $publicKey;
	}

	public function getAbstractedKeyPath($fileName = null): string
	{
		return 'internal-data://keys/' . ($fileName ?? '');
	}
}