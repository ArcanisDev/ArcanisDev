<?php

namespace XF\Mvc;

use XF\Http\Response;
use XF\Mvc\Renderer\AbstractRenderer;
use XF\Util\File;

use function get_class;

class View
{
	/**
	 * @var Renderer\AbstractRenderer
	 */
	protected $renderer;

	/**
	 * @var \XF\Http\Response
	 */
	protected $response;

	/**
	 * @var string
	 */
	protected $templateName = '';

	/**
	 * @var array
	 */
	protected $params = [];

	public function __construct(AbstractRenderer $renderer, Response $response, $templateName = '', array $params = [])
	{
		$this->renderer = $renderer;
		$this->response = $response;
		$this->templateName = $templateName;
		$this->params = $params;
	}

	public function getTemplateName()
	{
		return $this->templateName;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function renderTemplate($templateName, array $params = [])
	{
		$templater = $this->renderer->getTemplater();

		if (!strpos($templateName, ':') && strpos($this->templateName, ':'))
		{
			list($type) = $templater->getTemplateTypeAndName($templateName);
			$templateName = $type . ':' . $templateName;
		}

		return $templater->renderTemplate($templateName, $params);
	}

	protected function isException($e)
	{
		return ($e instanceof \Exception || $e instanceof \Throwable);
	}

	protected function renderExceptionHtml($e, &$error = null)
	{
		$traceHtml = '';

		if ($this->isException($e))
		{
			/** @var \Throwable $e */
			$error = '<b>' . get_class($e) . '</b>: ' . htmlspecialchars($e->getMessage()) . ' in <b>'
				. File::stripRootPathPrefix($e->getFile()) . '</b> at line <b>' . $e->getLine() . '</b>';

			foreach ($e->getTrace() AS $traceEntry)
			{
				$function = (isset($traceEntry['class']) ? $traceEntry['class'] . $traceEntry['type'] : '') . $traceEntry['function'];
				if (isset($traceEntry['file']) && isset($traceEntry['line']))
				{
					$fileLine = ' <span>in</span> <b>'
						. File::stripRootPathPrefix($traceEntry['file'])
						. "</b> <span>at line</span> <b>$traceEntry[line]</b>";
				}
				else
				{
					$fileLine = '';
				}
				$traceHtml .= "\t<li><b>" . htmlspecialchars($function) . "()</b>" . $fileLine . "</li>\n";
			}
		}
		else
		{
			$error = 'Unknown';
		}

		return "<div class=\"blockMessage blockMessage--error\"><div><div>$error</div> <ol>\n$traceHtml</ol></div></div>";
	}

	protected function renderExceptionXml($e)
	{
		$document = new \DOMDocument('1.0', 'utf-8');
		$document->formatOutput = true;

		$rootNode = $document->createElement('errors');
		$document->appendChild($rootNode);

		if ($this->isException($e))
		{
			/** @var \Exception $e */
			$exceptionMessage = $e->getMessage();

			$errorNode = \XF\Util\Xml::createDomElement(
				$document,
				'error',
				$exceptionMessage
			);
			$errorNode->setAttribute(
				'file',
				File::stripRootPathPrefix($e->getFile())
			);
			$errorNode->setAttribute('line', $e->getLine());
			$rootNode->appendChild($errorNode);

			$traceNode = $document->createElement('trace');

			foreach ($e->getTrace() AS $trace)
			{
				$function = (isset($trace['class']) ? $trace['class'] . $trace['type'] : '') . $trace['function'];

				if (!isset($trace['file']))
				{
					$trace['file'] = '';
				}
				if (!isset($trace['line']))
				{
					$trace['line'] = '';
				}

				$entryNode = $document->createElement('entry');
				$entryNode->setAttribute('function', $function);
				$entryNode->setAttribute(
					'file',
					File::stripRootPathPrefix($trace['file'])
				);
				$entryNode->setAttribute('line', $trace['line']);

				$traceNode->appendChild($entryNode);
			}

			$rootNode->appendChild($traceNode);
		}
		else
		{
			$rootNode->appendChild($document->createElement('error', 'Unknown error, trace unavailable'));
		}

		return $document;
	}
}