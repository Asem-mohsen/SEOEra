<script>
    function showLoading(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.innerHTML = `
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
        }
    }

    function showError(elementId, message = 'Failed to load data') {
        const element = document.getElementById(elementId);
        if (element) {
            element.innerHTML = `
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0">${message}</p>
                    </div>
                </div>
            `;
        }
    }

    // Load dashboard stats
    fetch('/admin/stats', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load stats');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('totalUsers').textContent = data.data.total_users || '0';
                document.getElementById('totalPosts').textContent = data.data.total_posts || '0';
                document.getElementById('newUsers').textContent = data.data.new_users || '0';
                document.getElementById('newPosts').textContent = data.data.new_posts || '0';
            } else {
                throw new Error(data.message || 'Failed to load stats');
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            document.getElementById('totalUsers').textContent = '0';
            document.getElementById('totalPosts').textContent = '0';
            document.getElementById('newUsers').textContent = '0';
            document.getElementById('newPosts').textContent = '0';
        });

    // Load recent users
    showLoading('recentUsers');
    fetch('/admin/users?per_page=5', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load users');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data && data.data.length > 0) {
                const usersHtml = data.data.map(user => `
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                            <div>
                                <strong class="d-block">${user.name}</strong>
                                <small class="text-muted">${user.email}</small>
                            </div>
                        </div>
                        <small class="text-muted">${new Date(user.created_at).toLocaleDateString()}</small>
                    </div>
                `).join('');
                document.getElementById('recentUsers').innerHTML = usersHtml;
            } else {
                document.getElementById('recentUsers').innerHTML = `
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-center">
                            <i class="fas fa-users text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">No users found</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading users:', error);
            showError('recentUsers', 'Failed to load users');
        });

    // Load recent posts
    showLoading('recentPosts');
    fetch('/admin/posts?per_page=5', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load posts');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data && data.data.length > 0) {
                const postsHtml = data.data.map(post => `
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-alt text-muted"></i>
                            </div>
                            <div>
                                <strong class="d-block">${post.title}</strong>
                                <small class="text-muted">${post.truncated_description || 'No description'}</small>
                            </div>
                        </div>
                        <small class="text-muted">${new Date(post.created_at).toLocaleDateString()}</small>
                    </div>
                `).join('');
                document.getElementById('recentPosts').innerHTML = postsHtml;
            } else {
                document.getElementById('recentPosts').innerHTML = `
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-center">
                            <i class="fas fa-file-alt text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">No posts found</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading posts:', error);
            showError('recentPosts', 'Failed to load posts');
        });
</script>