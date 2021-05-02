<?php


namespace core;


class Paginator
{
    private $results = [];
    private $lastPage;
    private $page;
    private $requests = [];


    public function pagination($countData, $limit, $page, $lastPage, $link, $requests = [])
    {
        $this->lastPage = $lastPage;
        $this->page = $page;
        $this->requests = $requests;

        $this->results = [
            'previous' => [],
            'startPage' => [],
            'endPage' => [],
            'next' => [],
            'link' => $link
        ];

        if ($countData < $limit || $page > $lastPage) {
            return null;
        }

        if ($page > $link + 1) {
            $tempNumber = $lastPage - $page;
            if ($tempNumber <= $link) {
                $link += $link - $tempNumber;
                $tempNumber = $lastPage - $link;
                if ($tempNumber < 2) {
                    if ($lastPage !== $page) {
                        $link = $lastPage - 2;

                    } else {
                        $link = $lastPage - 1;
                    }
                }
            }
            $this->results['previous'] = $this->createPaginationLink($page - $link, $page - 1);
        } else {
            $this->results['previous'] = $this->createPaginationLink(1, $page - 1);
        }
        if (count($this->results['previous']) >= 3 && $page > 4 && $lastPage > ($link * 2) + 1) {
            $this->results['startPage'][] = $this->paginationLink(1, 'start-page')
                . $this->paginationLink('...', 'start-dots');
        }

        if ($page + $link < $lastPage) {
            $tempData = $page - 1;
            if ($tempData <= $link) {
                $link += $link - $tempData;
                $tempData = $lastPage - $link;
                if ($tempData < 2) {
                    if (1 !== $page) {
                        $link = $lastPage - 2;

                    } else {
                        $link = $lastPage - 1;
                    }
                }
            }

            $this->results['next'] = $this->createPaginationLink($page + 1, $page + $link);
        } else {
            $this->results['next'] = $this->createPaginationLink($page + 1, $lastPage);
        }
        if (count($this->results['next']) >= 3 && $lastPage - $page > 3 && $lastPage > ($link * 2) + 1) {
            $this->results['endPage'][] = $this->paginationLink('...', 'end-dots')
                . $this->paginationLink($lastPage, 'last-page');
        }
        return $this;
    }

    private function createPaginationLink($start, $count)
    {
        $links = [];
        for ($i = $start; $i <= $count; $i++) {
            $links[] = $this->paginationLink($i, $i);
        }
        return $links;
    }

    private function paginationLink($label, $page, $active = '')
    {
        return "<li class='page-item $active'><a class='page-link' href='" . $this->getUrlPage($page) . "'>$label</a></li>";
    }

    private function getUrlPage($page)
    {
        unset($this->requests['page']);
        $query = http_build_query($this->requests);
        $url = getUrl() . '?page=' . $page . (!empty($query) ? '&' . $query : '');
        return $url;
    }

    public function render()
    {
        if (empty($this->results) || $this->lastPage < 2) {
            return false;
        }

        return '
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                ' . ($this->page > 1 ? $this->paginationLink('Назад', $this->page - 1) : '')
            . implode('', $this->results['startPage'])
            . implode('', $this->results['previous'])
            . $this->paginationLink($this->page, $this->page, 'active')
            . implode('', $this->results['next'])
            . implode('', $this->results['endPage'])
            . (($this->page < $this->lastPage) ? $this->paginationLink('Вперед', $this->page + 1) : '')
            . '
               </ul>
            </nav>
        ';
    }

}
