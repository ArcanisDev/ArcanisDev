<?php

namespace XF\Db;

/**
 * We may have adapters which access foreign databases but should not be used for XenForo itself.
 *
 * Adapters implementing this class are likely incompatible with XenForo.
 */
abstract class ForeignAdapter extends AbstractAdapter {}