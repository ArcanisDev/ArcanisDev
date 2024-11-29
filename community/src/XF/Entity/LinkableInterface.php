<?php

namespace XF\Entity;

interface LinkableInterface
{
	/**
	 * Gets the URL that will take someone to this content.
	 *
	 * @param bool  $canonical If true, should be built using the "canonical" prefix
	 * @param array $extraParams Usually empty, but any additional params for the content
	 * @param string|null  $hash Usually empty, but an additional hash that may be appended
	 *
	 * @return string
	 */
	public function getContentUrl(bool $canonical = false, array $extraParams = [], $hash = null);

	/**
	 * The name of the public-facing route that relates to this content. Some situations may append
	 * more specific actions to this. This will generally depend on the content being passed into
	 * the route to build the link.
	 *
	 * Note that the URL generated from getContentUrl may differ from the public route.
	 *
	 * If there is no public route that's applicable, return null.
	 *
	 * @return string|null
	 */
	public function getContentPublicRoute();

	/**
	 * Gets a printable title for this content. This will usually include a content type
	 * to help distinguish it in mixed usage scenarios.
	 *
	 * @param string $context A free-form string defining the usage context. Allows variation of results.
	 *
	 * @return string|\XF\Phrase
	 */
	public function getContentTitle(string $context = '');
}