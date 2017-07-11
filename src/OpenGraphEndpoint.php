<?php

namespace Evabioz\OGMiddleware;

abstract class OpenGraphEndpoint
{
	/** @var  string */
    protected $title;

    /** @var  string */
    protected $type;

    /** @var  string */
    protected $image;

    /** @var  string */
    protected $url;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

	/**
	 *
	 * Custom metadata properties to response.
	 *
	 * @return array
	 */
	abstract public function getMetadatas();
}