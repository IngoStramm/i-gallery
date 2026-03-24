(() => {
    let fileList = []
    const ajaxUrl = ajax_object.ajax_url
    const imagesPerPage = 12
    let currPage = 1
    let totalImages = 0
    let totalPages = totalImages > 0 ? totalImages / imagesPerPage : 1
    let imagesInCurrPage = 0

    function getGalleryData(postId, container) {
        container.innerHTML = `<span class="i-gallery-loader"></span>`
        const data = new FormData()
        data.append('action', 'ig_get_gallery')
        data.append('post_id', postId)
        fetch(ajaxUrl, {
            method: 'POST',
            body: data
        })
            .then((response) => response.json())
            .then((response) => {
                fileList = response.data.file_list
                totalImages = fileList.length
                totalPages = Math.ceil(totalImages / imagesPerPage)
            })
            .catch((error) => {
                console.log('error', error);
            })
            .finally(() => {
                renderGallery(container)
            })
    }

    function renderGallery(container) {
        container.innerHTML = ''
        const list = document.createElement('ul')
        list.classList.add('i-gallery-list')

        let startingIndex = currPage > 0 ? (currPage - 1) * imagesPerPage : 0
        startingIndex = startingIndex >= totalImages ? totalImages - imagesPerPage : startingIndex

        let endingIndex = startingIndex + imagesPerPage
        endingIndex = endingIndex > totalImages ? totalImages : endingIndex

        let i = startingIndex
        imagesInCurrPage = 0
        while (i < endingIndex) {
            const item = fileList[i]
            const listItem = document.createElement('li')
            listItem.classList.add('i-gallery-list-item')

            const btn = document.createElement('button')
            btn.type = 'button'
            btn.classList.add('i-gallery-list-btn')
            btn.dataset.index = i
            btn.addEventListener('click', renderModal)

            const img = document.createElement('img')
            img.classList.add('i-gallery-list-img')
            img.alt = item.alt_text
            img.src = item.file

            const imgOverlayer = document.createElement('div')
            imgOverlayer.classList.add('i-gallery-list-img-hover')

            const icon = `<svg class="i-gallery-list-img-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376C296.3 401.1 253.9 416 208 416 93.1 416 0 322.9 0 208S93.1 0 208 0 416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>`

            const imgTitle = document.createElement('div')
            imgTitle.classList.add('i-gallery-list-img-title')
            // imgTitle.innerHTML = limitStringByWordCount(item.title, 5)
            imgTitle.innerHTML = item.title

            imgOverlayer.append(imgTitle)
            imgOverlayer.innerHTML += icon

            btn.append(img)
            btn.append(imgOverlayer)
            listItem.append(btn)
            list.append(listItem)
            i++
            imagesInCurrPage++
        }
        container.append(list)
        renderPagination(container)
    }

    function closeModal(e) {
        if (e.target.tagName !== 'IMG') {
            removeModals()
        }
    }

    function removeModals() {
        const existingModals = document.querySelectorAll('.i-gallery-modal-container')
        for (const modal of existingModals) {
            modal.remove()
        }
        document.documentElement.style.overflow = ''
    }

    function renderModal(e) {
        removeModals()
        const index = e.target.dataset.index

        const container = document.createElement('div')
        container.classList.add('i-gallery-modal-container')
        container.addEventListener('click', closeModal)

        const modal = document.createElement('div')
        modal.classList.add('i-gallery-modal-popup')

        const btn = document.createElement('button')
        btn.type = 'button'
        btn.classList.add('i-gallery-modal-btn')
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M55.1 73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L147.2 256 9.9 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192.5 301.3 329.9 438.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.8 256 375.1 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192.5 210.7 55.1 73.4z"/></svg>`
        btn.addEventListener('click', closeModal)

        const img = document.createElement('img')
        img.classList.add('i-gallery-modal-image')
        img.src = fileList[index].file

        modal.append(btn)
        modal.append(img)
        container.append(modal)
        document.body.append(container)
        document.documentElement.style.overflow = 'hidden'
    }

    function changePage(e) {
        const btn = e.target
        currPage = parseInt(btn.dataset.page)
        const container = btn.closest('#i-gallery')
        if (!container) {
            return
        }
        renderGallery(container)
    }

    function paginationItem(index, textBtn = index, cssClasses = []) {
        const li = document.createElement('li')
        li.classList.add('i-gallery-pagination-item')
        const btn = document.createElement('button')
        btn.type = 'button'
        btn.classList.add('i-gallery-pagination-btn')
        cssClasses.forEach(cssClass => btn.classList.add(cssClass))
        if (index === currPage) {
            btn.classList.add('i-gallery-pagination-current-page')
        }
        btn.innerHTML = textBtn
        btn.dataset.page = index
        btn.disabled = currPage === index
        if (currPage !== index) {
            btn.addEventListener('click', changePage)
        }
        li.append(btn)
        return li
    }

    function renderPagination(container) {
        const ul = document.createElement('ul')
        ul.classList.add('i-gallery-pagination')

        const liFirstPage = paginationItem(1, `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160zm352-160l-160 160c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L269.3 256 406.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0z"/></svg>`, ['first-page'])
        ul.append(liFirstPage)

        const maxPagesInPagination = 3
        let prevPagesIndex = currPage - maxPagesInPagination

        if (prevPagesIndex <= 0) {
            prevPagesIndex = 1
        }

        for (let index = prevPagesIndex; index < currPage && index < totalPages; index++) {
            const li = paginationItem(index)
            ul.append(li)
        }

        for (let index = currPage; index <= currPage + maxPagesInPagination && index <= totalPages; index++) {
            const li = paginationItem(index)
            ul.append(li)
        }

        const liLastPage = paginationItem(totalPages, `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M439.1 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L371.2 256 233.9 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L179.2 256 41.9 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z"/></svg>`, ['last-page'])
        ul.append(liLastPage)

        container.append(ul)
    }

    function galleryInit() {
        const container = document.querySelector('#i-gallery')
        if (!container) {
            return
        }
        if (!fileList) {
            return
        }
        const postId = container.dataset.id
        getGalleryData(postId, container)
    }

    document.addEventListener('DOMContentLoaded', function () {
        galleryInit()
    })
})()