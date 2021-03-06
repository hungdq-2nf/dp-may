<?php

abstract class AbstractObserver
{
    abstract function update(AbstractSubject $subject_in);
}

abstract class AbstractSubject
{
    abstract function attach(AbstractObserver $observer_in);

    abstract function detach(AbstractObserver $observer_in);

    abstract function notify();
}

class PatternObserver extends AbstractObserver
{
    public function __construct()
    {
    }

    public function update(AbstractSubject $subject)
    {
        writeln('*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*');
        writeln(' new favorite patterns: ' . $subject->getFavorites());
        writeln('*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*');
    }
}

class PatternSubject extends AbstractSubject
{
    private $favoritePatterns = NULL;
    private $observers = array();

    function __construct()
    {
    }

    function attach(AbstractObserver $observer_in)
    {
        //could also use array_push($this->observers, $observer_in);
        $this->observers[] = $observer_in;
    }

    function detach(AbstractObserver $observer_in)
    {
        //$key = array_search($observer_in, $this->observers);
        foreach ($this->observers as $okey => $oval) {
            if ($oval == $observer_in) {
                unset($this->observers[$okey]);
            }
        }
    }

    function notify()
    {
        foreach ($this->observers as $obs) {
            $obs->update($this);
        }
    }

    function updateFavorites($newFavorites)
    {
        $this->favorites = $newFavorites;
        $this->notify();
    }

    function getFavorites()
    {
        return $this->favorites;
    }
}

writeln('');

$patternGossiper = new PatternSubject();
$patternGossipFan = new PatternObserver();
$patternGossiper->attach($patternGossipFan);
$patternGossiper->updateFavorites('abstract factory, decorator, visitor');
$patternGossiper->updateFavorites('abstract factory, observer, decorator');
$patternGossiper->detach($patternGossipFan);
$patternGossiper->updateFavorites('abstract factory, observer, paisley');
writeln('');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}

/* kq:

*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*
new favorite patterns: abstract factory, decorator, visitor
*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*

*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*
new favorite patterns: abstract factory, observer, decorator
*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*

